<?php
require_once 'secure.php';
if (!Helper::can('admin') && !Helper::can('manager')) {
  header('Location: 404.php');
  exit();
} 
$id = 0;
$userMap = new UserMap();
$groupMap = new GruppaMap();
$role_id = $_POST["role_id"];
if (isset($_GET['id'])) {
  $id = Helper::clearInt($_GET['id']);
}
$user = (new UserMap())->findById($id);
$header = (($id)?'Редактировать данные':'Добавить').' пользователя';
require_once 'template/header.php'; ?>
<section class="content-header">
  <h1><?=$header;?></h1>
  <ol class="breadcrumb">
    <li><a href="/index.php"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="list-user.php">Пользователь</a></li>
    <li class="active"><?=$header;?></li>
  </ol>
</section>
<div class="box-body">
  <form name='frm' method='post' >
  <div class="form-group">
  <label>Роль</label>
  <select class="form-control" name="role_id" onChange="document.frm.submit();">
      <? $roles = $userMap->arrRoles();
      foreach($roles as $role) { ?>
        <option value="<?= $role['id'];?>" <?= ($role_id === $role["id"]) ? "selected" : ""; ?> ><?= $role['value'];?></option>
      <? } ?>
    </select> 
  </div>
  </form>
    

  <form action="save-user.php" method="POST">
    <?php require_once '_formUser.php'; 
      if($role_id == 3 or $role_id == 4) { ?>
        <div class="form-group">
          <label>Отделение</label>
          <select class="form-control" name="otdel_id">
            <?= Helper::printSelectOptions($user->otdel_id, (new OtdelMap())->arrOtdels());?>
          </select>
        </div>
        <?php if($role_id == 4 ) {
          $groups = $groupMap->getAll(); ?>
          <div class="form-group">
          <label>Группа</label>
          <select class="form-control" name="gruppa_id">
            <? foreach($groups as $group) { ?>
              <option value="<?= $group['id'];?>" ><?= $group['name']; ?></option>
            <? } ?>
          </select>
        </div>
        <div class="form-group">
          <label>num_zach</label>
          <input type="text" class="form-control" name="num_zach">
        </div>
        <?php }} ?>
    <div class="form-group">
      <label>Заблокировать</label>
      <div class="radio">
        <label>
          <input type="radio" name="active" value="1" <?= ($user->active)?'checked':'';?>> Нет
        </label> &nbsp;
        <label>
          <input type="radio" name="active" value="0" <?= (!$user->active)?'checked':'';?>> Да
        </label>
      </div>
    </div>
    <input type="hidden" name="role_id" value="<?= $role_id; ?>">
    <div class="form-group">
      <button type="submit" name="saveUser" class="btn btn-primary">Сохранить</button>
    </div>
  </form>
</div>
<? require_once 'template/footer.php'; ?>