<?php
require_once 'secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
  header('Location: 404.php');
  exit();
}
if (isset($_POST['subject_id'])) {
  $subject = new Subject();
  $subject->otdel_id = Helper::clearInt($_POST['otdel_id']);
  $subject->subject_id = Helper::clearInt($_POST['subject_id']);
  $subject->name = Helper::clearString($_POST['name']);
  $subject->hours = Helper::clearInt($_POST["hours"]);
  if ((new subjectMap())->save($subject)) {
  header('Location: view-subject.php?id='.$subject->subject_id);
  } else {
    if ($subject->subject_id) {
      header('Location: add-subject.php?id='.$subject->subject_id);
    } else {
      header('Location: add-subject.php'); 
    }
  }
}