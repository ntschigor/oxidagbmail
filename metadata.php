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
 
/**
 * Module information
 */
$aModule = array(
    'id'           => 'te/mail',
    'title'        => 'te // mailing agb',
    'description'  => 'module to send your agb in order mail',
    'thumbnail'    => 'te_modulz.png',
    'version'      => '1.0',
    'author'       => 'Noel Tschigor',
    'email'        => 'info@techlines.de',
    'url'          => 'techlines.de',
    'extend'       => array(
        'oxemail' => 'te/mail/core/te_oxemail'
    )
);