<?php
/**
 *    This file is part of Order-Manage List Module for OXID eShop CE/PE/EE.
 *
 *    Ofree software: you can redistribute it and/or modify
 *    it under the terms of the MIT License.
 *
 *
 * @link      http://techlines.de
 * @package   main
 * @copyright Noel Tschigor
 */
 
class te_oxemail extends te_oxemail_parent
{

    public function sendOrderEmailToUser( $oOrder, $sSubject = null )
    {
       $myConfig = $this->getConfig();

        // add user defined stuff if there is any
        $oOrder = $this->_addUserInfoOrderEMail( $oOrder );

        $oShop = $this->_getShop();
        $this->_setMailParams( $oShop );

        $oUser = $oOrder->getOrderUser();
        $this->setUser( $oUser );

        // create messages
        $oSmarty = $this->_getSmarty();
        $this->setViewData( "order", $oOrder);

        if ( $myConfig->getConfigParam( "bl_perfLoadReviews" ) ) {
            $this->setViewData( "blShowReviewLink", true );
        }

        // Process view data array through oxOutput processor
        $this->_processViewArray();

        $this->setBody( $oSmarty->fetch( $this->_sOrderUserTemplate ) );
        $this->setAltBody( $oSmarty->fetch( $this->_sOrderUserPlainTemplate ) );

        // #586A
        if ( $sSubject === null ) {
            if ( $oSmarty->template_exists( $this->_sOrderUserSubjectTemplate) ) {
                $sSubject = $oSmarty->fetch( $this->_sOrderUserSubjectTemplate );
            } else {
                $sSubject = $oShop->oxshops__oxordersubject->getRawValue()." (#".$oOrder->oxorder__oxordernr->value.")";
            }
        }

        $this->setSubject( $sSubject );

        $sFullName = $oUser->oxuser__oxfname->getRawValue() . " " . $oUser->oxuser__oxlname->getRawValue();

        $this->setRecipient( $oUser->oxuser__oxusername->value, $sFullName );
        $this->setReplyTo( $oShop->oxshops__oxorderemail->value, $oShop->oxshops__oxname->getRawValue() );

        //set your agb
        if (file_exists($myConfig->getDir("agb.pdf", "agb", false)))
        {
            $this->addAttachment( $myConfig->getDir("agb.pdf", "agb", false) , 'agb.pdf', 'base64', 'application/pdf');
        }
        //set your widerruf
        if (file_exists($myConfig->getDir("widerruf.pdf", "agb", false)))
        {
            $this->addAttachment( $myConfig->getDir("widerruf.pdf", "agb", false) , 'widerruf.pdf', 'base64', 'application/pdf');
        }
                
        $blSuccess = $this->send();

        return $blSuccess;
        
    }

}
