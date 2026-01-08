<?php

namespace App\Controllers;

use App\Models\Visitor;

class VisitorController
{
    protected $visitorModel;

    public function __construct()
    {
        $this->visitorModel = new Visitor();
    }

    public function index()
    {
        $visitors = $this->visitorModel->getAllVisitors();
        require_once '../public/visitors/index.php';
    }

    public function logVisit($data)
    {
        if ($this->visitorModel->addVisitorLog($data)) {
            header('Location: /visitors/index.php?success=Visitor log added successfully.');
        } else {
            header('Location: /visitors/log.php?error=Failed to add visitor log.');
        }
    }

    public function viewVisitor($id)
    {
        $visitor = $this->visitorModel->getVisitorById($id);
        require_once '../public/visitors/view.php';
    }
}