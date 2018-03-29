<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 12/1/17
 * Time: 10:40 AM
 */

namespace Aragorn\JobManager\Mail\Template;

use Magento\Framework\Mail\Template\TransportBuilder as TBuilder;

class TransportBuilder extends TBuilder
{

    public function addAttachment(
        $body,
        $mimeType    = \Zend_Mime::TYPE_OCTETSTREAM,
        $filename    = null
    )
    {
        $this->message->createAttachment($body, $mimeType, \Zend_Mime::DISPOSITION_ATTACHMENT,
            \Zend_Mime::ENCODING_BASE64, $filename);
        return $this;
    }
}