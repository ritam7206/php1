<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

class SimplePDF
{
    private $lines = [];

    public function addText($x, $y, $text, $size = 10)
    {
        $text = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], (string) $text);
        $this->lines[] = "BT /F1 {$size} Tf {$x} {$y} Td ({$text}) Tj ET";
    }

    public function render()
    {
        $content = implode("\n", $this->lines);

        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream\nendobj\n"
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xrefPos = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xrefPos . "\n%%EOF";

        return $pdf;
    }
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="products.pdf"');

$pdf = new SimplePDF();
$pdf->addText(210, 800, 'Product List', 16);
$pdf->addText(30, 775, 'ID', 10);
$pdf->addText(80, 775, 'Product Name', 10);
$pdf->addText(250, 775, 'Category', 10);
$pdf->addText(330, 775, 'Price', 10);
$pdf->addText(390, 775, 'Qty', 10);
$pdf->addText(430, 775, 'Description', 10);

$result = $conn->query("SELECT pid, pname, category, price, quantity, description FROM products ORDER BY pid DESC");
$y = 755;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $description = trim($row['description']);
        $pdf->addText(30, $y, $row['pid'], 9);
        $pdf->addText(80, $y, $row['pname'], 9);
        $pdf->addText(250, $y, $row['category'], 9);
        $pdf->addText(330, $y, $row['price'], 9);
        $pdf->addText(390, $y, $row['quantity'], 9);
        $pdf->addText(430, $y, $description, 9);
        $y -= 18;

        if ($y < 80) {
            break;
        }
    }
} else {
    $pdf->addText(180, 760, 'No products found.', 12);
}

$conn->close();
echo $pdf->render();
exit();
