<?php
require_once('include/MVC/View/views/view.detail.php');

class AOS_ProductsViewDetail extends ViewDetail
{
    public function display()
    {
        $galleryHtml = '';

        if (!empty($this->bean->photo_url)) {

            $urlsString = urldecode($this->bean->photo_url);
            $urls = preg_split('/\s+/', trim($urlsString));

            $galleryHtml .= '<div style="display:flex; flex-wrap:wrap;">';

            foreach ($urls as $i => $url) {
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $galleryHtml .= '
                        <div style="margin:5px; text-align:center;">
                            <a href="'.$url.'" target="_blank">
                                <img src="'.$url.'" 
                                     style="max-width:150px; max-height:150px;
                                            border:1px solid #ccc; padding:2px;" />
                            </a>
                            <div style="font-size:12px;">Image '.($i+1).'</div>
                        </div>';
                }
            }

            $galleryHtml .= '</div>';
        }

        $this->ss->assign('PHOTO_GALLERY_HTML', $galleryHtml);
        
        parent::display();
    }
}
