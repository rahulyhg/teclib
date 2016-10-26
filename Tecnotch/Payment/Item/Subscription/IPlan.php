<?php
namespace Tecnotch\Payment\Item\Subscription;
                 
interface IPlan
{
    /* set Name */
    public function setName($value);

    /* get Name */
    public function getName();

    /* set Description */
    public function setDescription($value) ;

    /* get Description */
    public function getDescription();

    /* set SetupFee */
    public function setSetupFee($value);

    /* get SetupFee */
    public function getSetupFee();

    /* set Type */
    public function setType($value);

    /* get Type */
    public function getType();

    public function setTerms(array $value);

    /* get Terms */
    public function getTerms();

    /* set Terms */
    public function addTerm(\Tecnotch\Payment\Item\Subscription\Plan\Term $term);

    /* get Terms */
    public function getTerm($id);

    /* set State */
    public function setState($value);

    /* get State */
    public function getState();

}