import io
import re
import asyncio
import sys

import pytesseract
from PIL import Image
from fastapi import FastAPI, File, UploadFile
from pydantic import BaseModel

# ──────────────────────────────────────────────
# Konfigurasi Tesseract (path Windows)
# ──────────────────────────────────────────────
pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

# ──────────────────────────────────────────────
# App & Model
# ──────────────────────────────────────────────
app = FastAPI()


class OCRResponse(BaseModel):
    nominal_terdeteksi: float
    status: str


# ──────────────────────────────────────────────
# Konstanta
# ──────────────────────────────────────────────
SCALE      = 3   # Zoom 3× sebelum OCR — struk foto biasanya ~100 DPI,
                 # Tesseract butuh ≥300 DPI untuk akurasi optimal.
ROW_TOL    = 20  # Toleransi vertikal (px, setelah scaling) untuk
                 # mengelompokkan kata ke baris yang sama.
CONF_FLOOR = 0   # Minimal confidence Tesseract per-kata (0 = terima semua).


# ──────────────────────────────────────────────
# Helpers preprocessing
# ──────────────────────────────────────────────

def _preprocess(image: Image.Image) -> Image.Image:
    """
    Grayscale + zoom 3×.
    Tidak perlu binarize manual — Tesseract sudah menggunakan
    Otsu threshold secara internal dan hasilnya lebih konsisten.
    """
    gray = image.convert("L")
    w, h = gray.size
    return gray.resize((w * SCALE, h * SCALE), Image.LANCZOS)


def _extract_word_data(image: Image.Image) -> dict:
    """
    Jalankan Tesseract dan kembalikan dict word-level lengkap dengan
    koordinat (left, top) tiap kata. Ini kunci utama perbaikan:
    image_to_data jauh lebih andal dari image_to_string untuk layout
    struk yang memiliki dua kolom (label kiri, nilai kanan).
    """
    return pytesseract.image_to_data(
        image,
        lang="ind+eng",
        config="--psm 6 --oem 3",
        output_type=pytesseract.Output.DICT,
    )


# ──────────────────────────────────────────────
# Helpers ekstraksi nilai
# ──────────────────────────────────────────────

# Ganti fungsi _find_keyword_row_y dengan yang ini:
KEYWORDS = ["TOTAL", "HARGA JUAL", "GRAND TOTAL", "JUMLAH", "TUNAI"]

def _find_keyword_row_y(data: dict) -> int | None:
    for keyword in KEYWORDS:
        for i, text in enumerate(data["text"]):
            # Gunakan 'in' bukan '==' agar tahan typo OCR
            if keyword in text.strip().upper() and int(data["conf"][i]) >= CONF_FLOOR:
                return data["top"][i]
    return None


def _parse_rupiah(raw: str) -> float | None:
    """
    Normalisasi string angka struk ke float.
    Menangani semua format pemisah ribuan Indonesia:
      "12.800" → 12800.0
      "12,800" → 12800.0
      "12800"  → 12800.0
    """
    digits_only = re.sub(r"[^\d]", "", raw)
    return float(digits_only) if digits_only else None


def _get_rightmost_number_in_row(data: dict, row_y: int) -> float | None:
    """
    Dari semua kata di baris yang sama (|top − row_y| ≤ ROW_TOL),
    ambil kata paling kanan yang mengandung digit lalu parse ke float.

    Layout struk: label selalu di kiri, nilai selalu di kanan.
    Kata dengan koordinat X terbesar = nilai nominal yang dicari.
    """
    row_words = [
        (data["text"][i], data["left"][i])
        for i in range(len(data["text"]))
        if abs(data["top"][i] - row_y) <= ROW_TOL
        and data["text"][i].strip()
        and int(data["conf"][i]) >= CONF_FLOOR
    ]

    number_candidates = [
        (text, x) for text, x in row_words if re.search(r"\d", text)
    ]

    if not number_candidates:
        return None

    rightmost_text, _ = max(number_candidates, key=lambda t: t[1])
    return _parse_rupiah(rightmost_text)


def _fallback_regex(data: dict) -> float | None:
    """
    Fallback jika strategi bounding-box gagal (misal gambar sangat buram).
    Perbaikan vs kode lama:
      - Tangkap angka dengan titik MAUPUN koma sebagai pemisah ribuan.
      - Ambil angka TERAKHIR di baris (bukan pertama) karena nilai ada di kanan.
      - Pilih nilai terbesar antar semua baris TOTAL yang ditemukan.
    """
    full_text = "\n".join(data["text"])
    results = []

    for line in full_text.splitlines():
        pattern = "|".join(KEYWORDS)  # "TOTAL|HARGA JUAL|GRAND TOTAL|JUMLAH|TUNAI"
        if not re.search(pattern, line, re.IGNORECASE):
            continue
        matches = re.findall(r"\d+(?:[.,]\d{3})*", line)
        if matches:
            results.append(_parse_rupiah(matches[-1]))

    valid = [v for v in results if v is not None]
    return max(valid) if valid else None


# ──────────────────────────────────────────────
# Endpoint
# ──────────────────────────────────────────────

@app.post("/api/ai/ocr-struk", response_model=OCRResponse)
async def baca_struk(file: UploadFile = File(...)):
    try:
        contents = await file.read()
        image    = Image.open(io.BytesIO(contents))

        # 1. Preprocessing: grayscale + zoom 3×
        processed = _preprocess(image)

        # 2. OCR word-level (teks + koordinat x,y per kata)
        data = _extract_word_data(processed)

        # 3. Temukan baris TOTAL berdasarkan koordinat Y
        row_y = _find_keyword_row_y(data)

        if row_y is not None:
            # 4a. Ambil angka paling kanan di baris TOTAL
            nominal = _get_rightmost_number_in_row(data, row_y)
            if nominal is not None:
                return OCRResponse(nominal_terdeteksi=nominal, status="sukses")

        # 4b. Fallback: regex pada full-text jika bounding-box gagal
        nominal = _fallback_regex(data)
        if nominal is not None:
            return OCRResponse(nominal_terdeteksi=nominal, status="sukses_fallback")

        return OCRResponse(nominal_terdeteksi=0.0, status="gagal_mencari_total")

    except Exception as e:
        return OCRResponse(nominal_terdeteksi=0.0, status=f"error: {e}")


# ──────────────────────────────────────────────
# Entry point
# ──────────────────────────────────────────────

if __name__ == "__main__":
    import uvicorn
    uvicorn.run("ai_service:app", host="127.0.0.1", port=8000, reload=True)