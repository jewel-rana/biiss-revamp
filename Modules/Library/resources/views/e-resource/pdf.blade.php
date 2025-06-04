<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF.js Viewer with Zoom</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #eee;
        }
        #pdf-controls {
            margin: 10px;
            position: fixed;
            /*background: #f0f0f0;*/
            width: auto;
            align-content: center;
            padding: 5px 15px;
            border-radius: 14px;
            /*border: 1px solid #EADBDB;*/
        }
        #pdf-viewer {
            border: 1px solid #ccc;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div id="pdf-controls">
    <button onclick="zoomOut()">- In</button>
    <button onclick="zoomIn()">+ Out</button>
</div>

<canvas id="pdf-viewer"></canvas>

<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js';

    const url = "{{ asset( $library->file ) }}";
    let pdfDoc = null;
    let pageNum = 1;
    let scale = 1.5; // Initial zoom level
    const canvas = document.getElementById('pdf-viewer');
    const ctx = canvas.getContext('2d');

    function renderPage(num) {
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext);
        });
    }

    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        renderPage(pageNum);
    });

    function zoomIn() {
        scale += 0.2;
        renderPage(pageNum);
    }

    function zoomOut() {
        if (scale > 0.4) {
            scale -= 0.2;
            renderPage(pageNum);
        }
    }
</script>

</body>
</html>
