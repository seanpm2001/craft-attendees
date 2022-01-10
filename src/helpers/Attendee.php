<?php

namespace percipiolondon\attendees\helpers;

use yii\web\NotFoundHttpException;
use yii\web\Request;
use Craft;

use percipiolondon\attendees\elements\Attendee as AttendeeModel;

class Attendee
{
    public static function populateAttendeeFromPost( Request $request = null): AttendeeModel
    {
        if (!$request) {
            $request = Craft::$app->getRequest();
        }

        $attendeeId = $request->getBodyParam('attendeeId');

        if(!$attendeeId){
            $attendee = new AttendeeModel();
        }else{
            $attendee = AttendeeModel::find()->id($attendeeId)->one();

            if (!$attendee) {
                throw new NotFoundHttpException(Craft::t('craft-attendees', 'No attendee with the ID “{id}”', ['id' => $attendeeId]));
            }
        }

        $attendee->orgName = $request->getBodyParam('orgName');
        $attendee->orgUrn = $request->getBodyParam('orgUrn');
        $attendee->postCode = $request->getBodyParam('postCode');
        $attendee->name = $request->getBodyParam('name');
        $attendee->email = $request->getBodyParam('email');
        $attendee->jobRole = $request->getBodyParam('jobRole');
        $attendee->days = $request->getBodyParam('days');
        $attendee->newsletter = $request->getBodyParam('newsletter') ?? 0;
        $attendee->approved = $request->getBodyParam('approved') ?? 0;
        $attendee->eventId = $request->getBodyParam('event');

        return $attendee;
    }
}
