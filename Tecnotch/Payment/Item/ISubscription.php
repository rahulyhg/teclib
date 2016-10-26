<?php
namespace Tecnotch\Payment;
                 
interface ISubscription 
{
    /* set SetupFee */
    public function setSetupFee($value);

    /* get SetupFee */
    public function getSetupFee();

    /* set Tenure */
    public function setNoOfPayments($value);

    /* get Tenure */
    public function getNoOfPayments();

    /* set Interval */
    public function setInterval($value);

    /* get Interval */
    public function getInterval();

    /* set Occurrences */
    public function setOccurrences($value);

    /* get Occurrences */
    public function getOccurrences();

     /* set TrialPrice */
    public function setTrialPrice($value);

    /* get TrialPrice */
    public function getTrialPrice();

    /* set TrialInterval */
    public function setTrialInterval($value);

    /* get TrialInterval */
    public function getTrialInterval();

    /* set TrialOccurrences */
    public function setTrialOccurrences($value);

    /* get TrialOccurrences */
    public function getTrialOccurrences();

    /* set Trial2Price */
    public function setTrial2Price($value);

    /* get Trial2Price */
    public function getTrial2Price();
    /* set Trial2Interval */
    public function setTrial2Interval($value);

    /* get Trial2Interval */
    public function getTrial2Interval();
    /* set Trial2Occurrences */
    public function setTrial2Occurrences($value);

    /* get Trial2Occurrences */
    public function getTrial2Occurrences();

    /* get FULL NAMES i.e Month instead of M */

    public function getIntervalAbs();
    public function getTrialIntervalAbs();
    public function getTrial2IntervalAbs();
}