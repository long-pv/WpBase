<?php 
function add_pdf_viewer_script()
{
    if (!is_admin()) {
        ?>
        <!-- pdf viewer -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.5.141/pdf.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                if($('.pdfViewer').length){
                    // The workerSrc property shall be specified.
                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.5.141/pdf.worker.min.js';

                    $('.pdfViewer').each(function() {
                        let this_el = $(this);
                        let url_pdf = this_el.data('pdf');
                        
                        if(url_pdf){
                            let container = this_el.find('.pdfViewer__inner');
                            container.css('height', '600px');
                            container.css('overflow-y', 'scroll');
                            container.css('border', '1px solid #3E3E3E');
                            
                            let loadingTask = pdfjsLib.getDocument(url_pdf);
                            loadingTask.promise.then(function(pdf) {
                                let numPages = pdf.numPages;
                                for (let i = 1; i <= numPages; i++){
                                    pdf.getPage(i).then(function(page) {
                                        let scale = 1.5;
                                        let viewport = page.getViewport({ scale: scale, });

                                        // Support HiDPI-screens.
                                        let outputScale = window.devicePixelRatio || 1;
                                            
                                        let canvas = document.createElement('canvas');
                                        let context = canvas.getContext('2d');
                    
                                        canvas.width = Math.floor(viewport.width * outputScale);
                                        canvas.height = Math.floor(viewport.height * outputScale);
                                        canvas.style.width = "100%";
                                        let transform = outputScale !== 1
                                        ? [outputScale, 0, 0, outputScale, 0, 0]
                                        : null;
                    
                                        let renderContext = {
                                        canvasContext: context,
                                        transform: transform,
                                        viewport: viewport
                                        };
                                        container.append(canvas);
                                        page.render(renderContext);
                                    }); 
                                }
                            });
                        }
                    });
                }
            });
        </script>
        <!-- end -->
        <?php
    }
}
add_action('wp_footer', 'add_pdf_viewer_script', 99);

function custom_pdf_viewer_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'pdf' => 'https://pdfobject.com/pdf/sample.pdf',
        ),
        $atts,
        'custom_pdf_viewer'
    );

    $html = '<div class="pdfViewer mb-3" data-pdf="'. esc_html($atts['pdf']) .'"><div class="pdfViewer__inner"></div></div>';
    
    return $html;
}
add_shortcode('custom_pdf_viewer', 'custom_pdf_viewer_shortcode');