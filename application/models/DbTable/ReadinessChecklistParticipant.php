<?php

class Application_Model_DbTable_ReadinessChecklistParticipant extends Zend_Db_Table_Abstract {

    protected $_name = 'readiness_checklist_participants';
    protected $_primary = 'id';

    protected $_dependentTables = array('Application_Model_DbTable_ReadinessChecklistParticipantPlatform');

    protected $_referenceMap    = array(
        'ReadinessChecklistSurvey' => array(
            'columns'           => array('readiness_checklist_survey_id'),
            'refTableClass'     => 'Application_Model_DbTable_ReadinessChecklistSurvey',
            'refColumns'        => array('id')
        ),
        'Participant' => array(
            'columns'           => array('participant_id'),
            'refTableClass'     => 'Application_Model_DbTable_Participants',
            'refColumns'        => array('participant_id')
        ),
        'DataManager' => array(
            'columns'           => array('updated_by'),
            'refTableClass'     => 'Application_Model_DbTable_DataManagers',
            'refColumns'        => array('dm_id')
        )
    );

    public function addChecklistSurveyParticipants($checklistSurveyID, $participantIDs){
        $authNameSpace = new Zend_Session_Namespace('administrators');
        foreach ($participantIDs as $participantID) {
            $data  = [
                'readiness_checklist_survey_id' => $checklistSurveyID, 
                'participant_id' => $participantID, 
                'created_by' => $authNameSpace->admin_id, 
                'created_at' => new Zend_Db_Expr('now()')
            ];

            $this->insert($data);
        }
    }
}
