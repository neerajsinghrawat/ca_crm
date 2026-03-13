<?php

class ProductGalleryHook
{
    public function getImages($bean, $event, $arguments)
    {
        $bean->load_relationship('aos_products_documents_1');
        //$related_docs=array();
        $related_docs = ($bean->load_relationship('aos_products_documents_1') && isset($bean->aos_products_documents_1))?$bean->aos_products_documents_1->getBeans(): [];

        //$related_docs = $bean->aos_products_documents_1->getBeans();
        $images = array();

        foreach ($related_docs as $doc) {
            $revs = $doc->get_linked_beans('revisions', 'DocumentRevision');
            if (!empty($revs)) {
                $rev = array_shift($revs);

                // File location: upload/<id>
                $file_path = "upload/" . $rev->id;

                // Basic image check (skip if not image)
                $ext = strtolower(pathinfo($rev->filename, PATHINFO_EXTENSION));
                if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
                    $images[] = array(
                        'url' => $file_path,
                        'name' => $doc->document_name,
                        'link' => "index.php?module=Documents&action=DetailView&record={$doc->id}"
                    );
                }
            }
        }
         //echo "<pre>images==>";print_r($images);die;
        // Save array into bean for Smarty
        $bean->gallery_images = $images;
    }
}
