<?php

$id=htmlspecialchars($_GET['id'], ENT_QUOTES);
$sid=htmlspecialchars($_GET['sid'], ENT_QUOTES);


$ru = mysql_query("
  SELECT IDUSER, id_author
  FROM session, chat_users
  WHERE id=$id and IDUSER=id_author AND session.SID='$sid'"
);

if (mysql_num_rows($ru)==0) {
  Header("Location: http://".$_SERVER['HTTP_HOST']."/$_page/?".time());
  exit();
};

if (isset($_deleteimg)) {
  //������� �������� �� ����
  $ru = mysql_query("
  UPDATE chat_users
  SET `img`=''
  WHERE id='$id';"
  );
  //������� ����� ��������
  @unlink("modules/chat/images/$id.gif");
  @unlink("modules/chat/images/$id.jpg");
  @unlink("modules/chat/images/$id.png");

  Header("Location: http://".$_SERVER['HTTP_HOST']."/".$_page."/?".time());
  exit();
}
$userfile=$_FILES['userfile']['tmp_name'];
$userfile_size=$_FILES['userfile']['size'];
$user=strtolower(htmlspecialchars($_FILES['userfile']['name'], ENT_QUOTES));

//���������, ��� ����������� ���� - ��������
$sz=GetImageSize($userfile);
if (!(ereg("^.+\.(gif|jpg|png)$", $user) && ($sz[2]==1 || $sz[2]==2 || $sz[2]==3))) {
  $chat_my_msg = "<p>��������� ���� �� �������� ��������� � ������� GIF/JPG/PNG!</p>";
  return;
}

//���� ������ ����� ������ ���������
if ($userfile_size > 204800) {
  $chat_my_msg = "<p>��������� ���� ��������� ������ 200 ��!</p>";
  return;
}

//���������� ������ ��������

$sz[0]; //������
$sz[1]; //������

//���� ������ �������� ������ 800x600
if ($sz[0]>800 || $sz[1]>600) {
  $chat_my_msg = "<p>������ �������� ��������� 800x600px!</p>";
  return;
}

$uploadfile=getcwd()."/modules/chat/images/$id.".substr($user, -3);
$filename="$id.".substr($user, -3);

if (move_uploaded_file($userfile, $uploadfile)) {
  //��������� ������ �������� � ����
  $ru = mysql_query("
  UPDATE chat_users
  SET `img`='$filename'
  WHERE id='$id';"
  );
}

Header("Location: http://".$_SERVER['HTTP_HOST']."/".$_page."/?".time());
exit();

?>