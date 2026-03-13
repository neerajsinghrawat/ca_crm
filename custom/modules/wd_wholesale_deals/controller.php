<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class wd_wholesale_dealsController extends SugarController
{
    public function action_sendAgreementViaDocusign()
    {
        $deal = BeanFactory::getBean('wd_wholesale_deals', $_REQUEST['record']);
        if (empty($deal->id)) {
            sugar_die('Deal not found');
        }

        $deal->docusign_envelope_id = 'ENV-' . strtoupper(substr(create_guid(), 0, 10));
        $deal->agreement_status = 'sent';
        $deal->docusign_status = 'sent';
        $deal->save();

        SugarApplication::redirect('index.php?module=wd_wholesale_deals&action=DetailView&record=' . $deal->id);
    }
}
