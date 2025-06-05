<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF.js Viewer</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: sans-serif;
            display: flex;
        }

        #container {
            top: 0;
            left: 0;
            right: 0;
            bottom: 20px;
            position: fixed;
            display: flex;
        }

        #sidebar {
            width: 150px;
            background: #f4f4f4;
            overflow-y: auto;
            padding: 5px;
        }

        #viewer-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #toolbar {
            background: #fff;
            padding: 5px;
            display: flex;
            gap: 5px;
            position: sticky;
            top: 0;
            z-index: 10;
            margin: 0 auto;
        }

        #viewer-container {
            flex: 1;
            overflow-y: auto;
            background: #ddd;
        }

        .page-container {
            position: relative;
            display: flex;
            justify-content: center;
            margin: 10px;
        }

        .page-container canvas {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .page-number-label {
            position: absolute;
            top: 5px;
            right: auto;
            background: rgba(181, 176, 176, 0.12);
            color: #110d7e;
            font-size: 16px;
            padding: 5px 9px;
            border-radius: 2px;
            /* padding: 10px; */
            border: 1px solid #ECDEDE;
            left: auto;
            /* bottom: 25; */
        }

        .thumbnail-container {
            position: relative;
            margin-bottom: 5px;
        }

        .thumbnail-container canvas {
            width: 100%;
            cursor: pointer;
            border: 1px solid #ccc;
        }

        .thumbnail-page-number {
            position: absolute;
            bottom: 7px;
            right: 2px;
            background: rgba(136, 131, 131, 0.15);
            color: #0f0f0f;
            font-size: 18px;
            padding: 1px 3px;
            border-radius: 2px;
            border: 1px solid #ccc8c8;
        }
    </style>
</head>
<body>
<div id="container">
    <div id="sidebar"></div>

    <div id="viewer-wrapper">
        <div id="toolbar">
            <button onclick="zoomOut()">-</button>
            <button onclick="zoomIn()">+</button>
            <input type="number" id="page-number" min="1" placeholder="Page #" style="width: 60px;">
            <button onclick="goToPage()">Go</button>
        </div>
        <div id="viewer-container"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
<script>
    const url = "{{ asset($library->file ?? 'storage/pdfs/sample.pdf') }}";
    let pdfDoc = null;
    let scale = 1.0;

    const viewerContainer = document.getElementById('viewer-container');
    const sidebar = document.getElementById('sidebar');
    const pageNumberInput = document.getElementById('page-number');

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js';

    pdfjsLib.getDocument(url).promise.then(doc => {
        pdfDoc = doc;
        createPageContainers();
        renderAllPages();
        renderThumbnails();
    });

    function createPageContainers() {
        for (let num = 1; num <= pdfDoc.numPages; num++) {
            const pageContainer = document.createElement('div');
            pageContainer.className = 'page-container';
            pageContainer.dataset.pageNumber = num;

            const canvas = document.createElement('canvas');
            canvas.dataset.pageNumber = num;
            pageContainer.appendChild(canvas);

            const pageNumberLabel = document.createElement('div');
            pageNumberLabel.className = 'page-number-label';
            pageNumberLabel.textContent = num;
            pageContainer.appendChild(pageNumberLabel);

            viewerContainer.appendChild(pageContainer);
        }
    }

    function renderAllPages() {
        const canvases = viewerContainer.querySelectorAll('canvas');
        canvases.forEach(canvas => {
            const num = parseInt(canvas.dataset.pageNumber);
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({scale});
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                const context = canvas.getContext('2d');
                page.render({canvasContext: context, viewport: viewport});
            });
        });
    }

    function renderThumbnails() {
        sidebar.innerHTML = '';
        for (let num = 1; num <= pdfDoc.numPages; num++) {
            pdfDoc.getPage(num).then(page => {
                const thumbScale = 0.2;
                const viewport = page.getViewport({scale: thumbScale});
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                page.render({canvasContext: context, viewport: viewport});

                const thumbContainer = document.createElement('div');
                thumbContainer.className = 'thumbnail-container';
                thumbContainer.appendChild(canvas);

                const pageNumberLabel = document.createElement('div');
                pageNumberLabel.className = 'thumbnail-page-number';
                pageNumberLabel.textContent = num;
                thumbContainer.appendChild(pageNumberLabel);

                thumbContainer.addEventListener('click', () => {
                    const pageContainers = viewerContainer.querySelectorAll('.page-container');
                    pageContainers[num - 1].scrollIntoView({behavior: 'smooth'});
                });

                sidebar.appendChild(thumbContainer);
            });
        }
    }

    function zoomIn() {
        scale += 0.1;
        renderAllPages();
    }

    function zoomOut() {
        scale = Math.max(0.1, scale - 0.1);
        renderAllPages();
    }

    function goToPage() {
        const pageNum = parseInt(pageNumberInput.value);
        if (pageNum >= 1 && pageNum <= pdfDoc.numPages) {
            const pageContainers = viewerContainer.querySelectorAll('.page-container');
            pageContainers[pageNum - 1].scrollIntoView({behavior: 'smooth'});
        } else {
            alert(`Enter a valid page (1-${pdfDoc.numPages})`);
        }
    }

    // ✅ Robust current page tracking
    viewerContainer.addEventListener('scroll', () => {
        const pageContainers = viewerContainer.querySelectorAll('.page-container');
        let closestPage = 1;
        let minDistance = Infinity;
        pageContainers.forEach(container => {
            const rect = container.getBoundingClientRect();
            const distance = Math.abs(rect.top - viewerContainer.getBoundingClientRect().top);
            if (distance < minDistance) {
                minDistance = distance;
                closestPage = parseInt(container.dataset.pageNumber);
            }
        });
        pageNumberInput.value = closestPage;
    });
</script>
</body>
</html>
