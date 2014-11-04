<?php

class Issue
{

    public $titre;

    public $labels;

    public $label;

    public $status;

    public $last_update;

    public function __construct($issue_object)
    {
        $this->titre = $issue_object->title;
        $this->labels = $issue_object->labels;
        $this->status = $issue_object->state;
        $date = new DateTime($issue_object->updated_at);
        $this->last_update = $date->format("d\/m\/Y");
        
        if ($this->status == "open") {} else {}
        
        foreach ($this->labels as $label) {
            foreach (GithubApi::$labels as $gha_label) {
                if ($label->name == $gha_label->name) {
                    $this->label = $label;
                    break;
                }
            }
        }
    }
}
?>