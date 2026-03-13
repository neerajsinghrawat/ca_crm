<?php
require_once('include/MVC/View/views/view.detail.php');
class ta_trade_appraisalViewDetail extends ViewDetail
{
    public function display()
    {
        global $sugar_config;
        $html = "<div style='display:flex;flex-wrap:wrap;'>";
        // 🔵 images
        if (!empty($this->bean->vehicle_photos)) {
            $photos = explode(',', $this->bean->vehicle_photos);
            $index = 0;
            foreach ($photos as $img) {
                $img = trim($img);
                if ($img) {
                    $fullPath = $sugar_config['site_url'] . '/' . $img;
                    $html .= "
                    <div style='margin:10px;text-align:center'>
                        <img src='{$fullPath}' 
                             class='vehicle_img'
                             data-src='{$fullPath}'
                             data-index='{$index}'
                             style='max-width:150px;height:120px;display:block;border:1px solid #ccc;padding:3px;cursor:pointer;'>
                    </div>";
                    $index++;
                }
            }
        }
        $html .= "</div>";

        // 🔵 popup
        $html .= '
        <div id="imgPopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
             background:rgba(0,0,0,0.92);z-index:99999;text-align:center;">

             <!-- Close -->
             <span id="closePopup" 
                   style="position:absolute;top:18px;right:36px;color:#fff;font-size:48px;cursor:pointer;line-height:1;z-index:2;">×</span>

             <!-- Prev Button -->
             <span id="prevImg"
                   style="position:absolute;top:50%;left:20px;transform:translateY(-50%);
                          color:#fff;font-size:52px;cursor:pointer;user-select:none;z-index:2;
                          background:rgba(255,255,255,0.1);border-radius:50%;width:60px;height:60px;
                          display:flex;align-items:flex-start;justify-content:center;line-height:1;">&#8249;</span>

             <!-- Next Button -->
             <span id="nextImg"
                   style="position:absolute;top:50%;right:20px;transform:translateY(-50%);
                          color:#fff;font-size:52px;cursor:pointer;user-select:none;z-index:2;
                          background:rgba(255,255,255,0.1);border-radius:50%;width:60px;height:60px;
                          display:flex;align-items:flex-start;justify-content:center;line-height:1;">&#8250;</span>

             <!-- Zoom Buttons -->
             <div style="position:absolute;bottom:24px;left:50%;transform:translateX(-50%);
                         display:flex;gap:12px;z-index:2;">
                 <button id="zoomIn"
                         style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.4);
                                border-radius:6px;padding:8px 20px;font-size:22px;cursor:pointer;">+</button>
                 <button id="zoomOut"
                         style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.4);
                                border-radius:6px;padding:8px 20px;font-size:22px;cursor:pointer;">−</button>
                 <button id="zoomReset"
                         style="background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.4);
                                border-radius:6px;padding:8px 16px;font-size:14px;cursor:pointer;">Reset</button>
             </div>

             <!-- Image counter -->
             <div id="imgCounter"
                  style="position:absolute;top:22px;left:50%;transform:translateX(-50%);
                         color:#fff;font-size:16px;background:rgba(0,0,0,0.4);
                         padding:4px 14px;border-radius:20px;"></div>

             <!-- Main image wrapper (overflow hidden for zoom containment) -->
             <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                 <img id="popupImg"
                      style="max-width:88%;max-height:85%;border:5px solid #fff;border-radius:8px;
                             transition:transform 0.2s ease;transform-origin:center center;cursor:zoom-in;">
             </div>
        </div>

        <script>
        $(document).ready(function(){
            var allImgs = [];
            var currentIndex = 0;
            var zoomLevel = 1;
            var zoomStep = 0.25;
            var maxZoom = 4;
            var minZoom = 0.5;

            // Collect all images in order
            $(".vehicle_img").each(function(){
                allImgs.push($(this).data("src"));
            });

            function openPopup(index){
                currentIndex = index;
                zoomLevel = 1;
                applyZoom();
                $("#popupImg").attr("src", allImgs[currentIndex]);
                updateCounter();
                $("#imgPopup").fadeIn(200);
            }

            function updateCounter(){
                $("#imgCounter").text((currentIndex + 1) + " / " + allImgs.length);
                // Hide prev/next if only 1 image
                if(allImgs.length <= 1){
                    $("#prevImg, #nextImg").hide();
                } else {
                    $("#prevImg, #nextImg").show();
                }
            }

            function applyZoom(){
                $("#popupImg").css("transform", "scale(" + zoomLevel + ")");
                if(zoomLevel > 1){
                    $("#popupImg").css("cursor","zoom-out");
                } else {
                    $("#popupImg").css("cursor","zoom-in");
                }
            }

            // Open on thumbnail click
            $(document).on("click", ".vehicle_img", function(){
                var idx = parseInt($(this).data("index")) || 0;
                openPopup(idx);
            });

            // Close button
            $(document).on("click", "#closePopup", function(){
                $("#imgPopup").fadeOut(200);
            });

            // Background click to close (not on image/buttons)
            $(document).on("click", "#imgPopup", function(e){
                if($(e.target).is("#imgPopup")){
                    $("#imgPopup").fadeOut(200);
                }
            });

            // Prev image
            $(document).on("click", "#prevImg", function(e){
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + allImgs.length) % allImgs.length;
                zoomLevel = 1;
                applyZoom();
                $("#popupImg").attr("src", allImgs[currentIndex]);
                updateCounter();
            });

            // Next image
            $(document).on("click", "#nextImg", function(e){
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % allImgs.length;
                zoomLevel = 1;
                applyZoom();
                $("#popupImg").attr("src", allImgs[currentIndex]);
                updateCounter();
            });

            // Zoom In
            $(document).on("click", "#zoomIn", function(e){
                e.stopPropagation();
                if(zoomLevel < maxZoom){ zoomLevel += zoomStep; applyZoom(); }
            });

            // Zoom Out
            $(document).on("click", "#zoomOut", function(e){
                e.stopPropagation();
                if(zoomLevel > minZoom){ zoomLevel -= zoomStep; applyZoom(); }
            });

            // Reset zoom
            $(document).on("click", "#zoomReset", function(e){
                e.stopPropagation();
                zoomLevel = 1;
                applyZoom();
            });

            // Click on image to toggle zoom
            $(document).on("click", "#popupImg", function(e){
                e.stopPropagation();
                if(zoomLevel === 1){
                    zoomLevel = 2;
                } else {
                    zoomLevel = 1;
                }
                applyZoom();
            });

            // Keyboard navigation
            $(document).on("keydown", function(e){
                if($("#imgPopup").is(":visible")){
                    if(e.key === "ArrowRight") $("#nextImg").trigger("click");
                    if(e.key === "ArrowLeft")  $("#prevImg").trigger("click");
                    if(e.key === "Escape")     $("#closePopup").trigger("click");
                    if(e.key === "+")          $("#zoomIn").trigger("click");
                    if(e.key === "-")          $("#zoomOut").trigger("click");
                }
            });

            // Mouse wheel zoom inside popup
            $(document).on("wheel", "#imgPopup", function(e){
                e.preventDefault();
                if(e.originalEvent.deltaY < 0){
                    if(zoomLevel < maxZoom){ zoomLevel += zoomStep; applyZoom(); }
                } else {
                    if(zoomLevel > minZoom){ zoomLevel -= zoomStep; applyZoom(); }
                }
            });
        });
        </script>
        ';

        $this->ss->assign('VEHICLE_PHOTOS_HTML', $html);
        parent::display(); ?>
       <script>
            $(document).ready(function(){
            function disableInlineVehicle(){
                var td = $("div[field='vehicle_photos']");
                td.removeClass("inlineEdit");
                td.find(".inlineEditIcon").hide();
                td.off();
                td.removeAttr("onclick");
                td.find("*").off();
            }
            disableInlineVehicle();
            setInterval(function(){
                disableInlineVehicle();
            }, 1000);
        });</script><?php
    }
}