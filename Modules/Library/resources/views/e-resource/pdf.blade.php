<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF.js Viewer with Loader</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: row;
            font-family: sans-serif;
        }
        #container {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: fixed;
            display: flex;
        }
        #sidebar {
            width: 150px;
            background: #f4f4f4;
            overflow-y: auto;
            padding: 5px;
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
            border: 1px solid #ECDEDE;
            left: auto;
        }
        #toolbar {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 5px;
            display: flex;
            gap: 5px;
            z-index: 9999;
            font-size: 14px;
        }
        #toolbar button{
            font-size: 20px;
        }
        /* Loader overlay */
        #loading {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        .spinner {
            border: 8px solid #eee;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div id="loading"><span class="spinner"><i class="fa fa-spinner"></i></span></div>
<div id="container">
    <div id="sidebar"></div>
    <div id="viewer-container">
        <div id="toolbar">
            <button onclick="zoomOut()">-</button>
            <button onclick="zoomIn()">+</button>
            <input type="number" id="page-number" min="1" placeholder="Page #">
            <button onclick="goToPage()">Go</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
<script>
    const url = "{{ asset($library->file) }}";
    let pdfDoc = null;
    let scale = 1.5;

    const viewerContainer = document.getElementById('viewer-container');
    const sidebar = document.getElementById('sidebar');
    const loading = document.getElementById('loading');

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js';

    loading.style.display = 'flex'; // Show loader

    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        renderThumbnails();
        renderAllPages();
        loading.style.display = 'none'; // Hide loader after rendering
    }).catch(err => {
        loading.textContent = 'Failed to load PDF';
        console.error(err);
    });

    function renderAllPages() {
        viewerContainer.querySelectorAll('.page-container').forEach(c => c.remove());
        for (let num = 1; num <= pdfDoc.numPages; num++) {
            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({scale});
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({canvasContext: context, viewport: viewport});

                const pageContainer = document.createElement('div');
                pageContainer.className = 'page-container';
                pageContainer.appendChild(canvas);

                const pageNumberLabel = document.createElement('div');
                pageNumberLabel.className = 'page-number-label';
                pageNumberLabel.textContent = num;
                pageContainer.appendChild(pageNumberLabel);

                viewerContainer.appendChild(pageContainer);
            });
        }
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
                    const mainPageList = viewerContainer.querySelectorAll('.page-container');
                    if (mainPageList[num - 1]) {
                        mainPageList[num - 1].scrollIntoView({behavior: 'smooth'});
                        document.getElementById('page-number').value = num; // update input
                    }
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
        const pageNum = parseInt(document.getElementById('page-number').value);
        if (pageNum >= 1 && pageNum <= pdfDoc.numPages) {
            const mainPageList = viewerContainer.querySelectorAll('.page-container');
            if (mainPageList[pageNum - 1]) {
                mainPageList[pageNum - 1].scrollIntoView({behavior: 'smooth'});
            }
        } else {
            alert(`Invalid page number! Enter between 1 and ${pdfDoc.numPages}.`);
        }
    }
    viewerContainer.addEventListener('scroll', () => {
        const pageContainers = viewerContainer.querySelectorAll('.page-container');
        let currentPage = 1;

        for (let i = 0; i < pageContainers.length; i++) {
            const rect = pageContainers[i].getBoundingClientRect();
            // Check if the top of the page is visible in the viewer
            if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
                currentPage = i + 1;
                break;
            }
            // Fallback: if partially visible
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                currentPage = i + 1;
            }
        }
        document.getElementById('page-number').value = currentPage;
    });

</script>
</body>
</html>
