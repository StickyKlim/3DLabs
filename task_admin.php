<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Project </title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<script src="threejs.org/build/three.js"></script>
	<script src="threejs.org/examples/js/loaders/GLTFLoader.js"></script>
	<script src="threejs.org/examples/js/controls/OrbitControls.js"></script>
<?php 
include ("base.php");
if(isset($_GET['id'])){
	$result=pg_query($link, 'SELECT module, name FROM "Task" where id_task='."'".$_GET['id']."'");
	while ($row = pg_fetch_row($result)) {
		echo "<h1>".$row[0].": ".$row[1]."</h1>";
	}
} ?>

<ul class="menu">
    <li><a href="index.php">Главная страница</a></li>
    <li>Методические материалы:</li>
	<ul>
<?php
include ("base.php");
$result=pg_query($link, 'select distinct(name) from "Guide"');
	while ($row = pg_fetch_row($result)) {
			echo '<li><a href="comp.php?name='.$row[0].'">'.$row[0].'</a></li>';
		}
?>
	</ul>
	<li><a href="task_list.php">Задания</a> </li>
	<li><a href="cont.php">Обратная связь</a></li>
	<li><a href="adminin.php">Администрация</a></li>
</ul>

<div class="main">
<form action="task_admin.php" method="GET">
	<div class="table1">
	<h3>Таблица: Задание</h3>
	<?php
	include ("base.php");
	if(isset($_GET['id'])){
		$model=pg_query($link, 'SELECT * FROM "Task" where id_task='."'".$_GET['id']."'");
		while ($row_m = pg_fetch_row($model)) {
			echo '	
			<textarea name="id" id="id" placeholder="ID">'.$row_m[0].'</textarea><br>
			<textarea name="name" id="name" placeholder="Задание">'.$row_m[1].'</textarea><br>
			<textarea name="descript" id="descript" rows=20 placeholder="Описание">'.$row_m[2].'</textarea><br>
			<textarea name="module" id="module" placeholder="Модуль">'.$row_m[3].'</textarea><br><br><br>';
		}
	}
	?>
	
	<h3>Таблица: Ссылка на файлы</h3>
	<?php
	include ("base.php");
	if(isset($_GET['id'])){
		$comp=pg_query($link, 'SELECT * FROM "TaskFiles" where id_task='."'".$_GET['id']."'");
		while ($row_c = pg_fetch_row($comp)) {
			echo '	
			<textarea name="scheme" id="scheme" placeholder="Чертеж">'.$row_c[1].'</textarea><br>
			<textarea name="pdf" id="pdf" placeholder="PDF">'.$row_c[2].'</textarea><br>
			<textarea name="id_files" id="id_files" placeholder="ID файлов">'.$row_c[3].'</textarea><br><br><br>';
		}
	}
	?>
	<h3>Таблица: Настройки</h3>
	<?php
	include ("base.php");
	if(isset($_GET['id'])){
		$set=pg_query($link, 'SELECT * FROM "Settings" where id_task='."'".$_GET['id']."'");
		while ($row_s = pg_fetch_row($set)) {
			echo '	
			<textarea name="3d_mod" id="name" placeholder="model_name/scene.gltf">'.$row_s[1].'</textarea><br>
			<textarea name="x_size" id="x_size" placeholder="Размер Х">'.$row_s[2].'</textarea><br>
			<textarea name="y_size" id="y_size" placeholder="Размер Y">'.$row_s[3].'</textarea><br>
			<textarea name="z_size" id="z_size" placeholder="Размер Z">'.$row_s[4].'</textarea><br><br><br>';
		}
	}
	?>
	<div class="but">
	<input type="submit" name="add" value="Обновить">
	<input type="submit" name="del" value="Удалить"><br>
	</div></div>
</form>
<?php
include ("base.php");
    if(isset($_GET['add'])){
		$set_del=pg_query($link, 'DELETE FROM "Settings" where id_task='.$_GET['id']);
		$comp_del=pg_query($link, 'DELETE FROM "TaskFiles" where id_task='.$_GET['id']);
		$model_del=pg_query($link, 'DELETE FROM "Task" where id_task='.$_GET['id']);
		$model=pg_query($link, 'INSERT INTO "Task" VALUES ('.$_GET['id'].",'".$_GET['name']."','".$_GET['descript']."','".$_GET['module']."');");
		$comp=pg_query($link, 'INSERT INTO "TaskFiles" VALUES ('.$_GET['id'].",'".$_GET['scheme']."','".$_GET['pdf']."','".$_GET['id_files']."');");
		$set=pg_query($link, 'INSERT INTO "Settings" VALUES ('.$_GET['id'].",'".$_GET['3d_mod']."',".$_GET['x_size'].",".$_GET['y_size'].",".$_GET['z_size'].");");
			echo "<meta http-equiv='refresh' content='0'>";
			// echo "<script> if ( window.history.replaceState ) {
			// window.history.replaceState( null, null, window.location.href );
			// }
			// window.location = window.location.href;</script>";
	}
?>

<?php
include ("base.php");
    if(isset($_GET['del'])){
		$set_del=pg_query($link, 'DELETE FROM "Settings" where id_task='.$_GET['id']);
		$comp_del=pg_query($link, 'DELETE FROM "TaskFiles" where id_task='.$_GET['id']);
		$model_del=pg_query($link, 'DELETE FROM "Task" where id_task='.$_GET['id']);
	}
?>
<div class="set">
<?php
include ("base.php");
if(isset($_GET['id'])){
	$result=pg_query($link, 'SELECT scheme, pdf FROM "TaskFiles" where id_task='."'".$_GET['id']."'");
	while ($row = pg_fetch_row($result)) {
		echo '<h2>Ход работы:</h2><br><embed src="'.$row[1].'" width="80%" height="850px"/><br>
    <a href="'.$row[0].'" download>Скачать чертеж<br>
    <img src="'.$row[0].'" width="90%" heigth="90%"><br>';
	}
}
?>

</div>
</div>

 <script>
 <?php
include ("base.php");
$result=pg_query($link, 'SELECT * FROM "Settings" where id_task='."'".$_GET['id']."'");
while ($row = pg_fetch_row($result)) {
	$urlad = $row[1];
	$x_s =$row[2];
	$y_s =$row[3];
	$z_s =$row[4];
}
echo "let url='".$urlad."',";
echo "x_s=".$x_s.",";
echo "y_s=".$y_s.",";
echo "z_s=".$z_s.",";

?>
	scene, camera, renderer;

	function car() {
	  renderer = new THREE.WebGLRenderer({antialias:true});
	  renderer.setSize(1600,900);
	  renderer.setClearColor(0x000000, 0);
	  document.body.appendChild(renderer.domElement);

	  scene = new THREE.Scene();
	  scene.background = new THREE.Color("#2F4F4F");
	  camera = new THREE.PerspectiveCamera(30,window.innerWidth/window.innerHeight,1,3000);

	  hlight = new THREE.AmbientLight (0x404040,1);
	  scene.add(hlight);

	  directionalLight = new THREE.DirectionalLight('white',20);
	  directionalLight.position.set(0,1,0);
	  directionalLight.castShadow = true;
	  scene.add(directionalLight);
	  light = new THREE.PointLight(0xc4c4c4,5);
	  light.position.set(600,600,-1200);
	  light2 = new THREE.PointLight(0xc4c4c4,3);
	  light2.position.set(1000,2000,0);
	  light3 = new THREE.PointLight(0xc4c4c4,5);
	  light3.position.set(0,-700,-500);
	  light4 = new THREE.PointLight(0xc4c4c4,4);
	  light4.position.set(-300,400,2000);
	  light5 = new THREE.PointLight(0xc4c4c4,3);
	  light5.position.set(-1000,600,800);
	  
	  scene.add(light);
	  scene.add(light2);
	  scene.add(light3);
	  scene.add(light4);
	  scene.add(light5);
	  
	  let controls = new THREE.OrbitControls( camera, renderer.domElement );

	  camera.rotation.y = 45/180*Math.PI;
	  camera.position.x = 300;
	  camera.position.y = 200;
	  camera.position.z = 200;
	  controls.update();
	  
	  loader = new THREE.GLTFLoader();
	  loader.load(url, function(gltf){
		car = gltf.scene.children[0];
		car.scale.set(x_s,y_s,z_s);
		car.position.set(0, y_s, 0);
		scene.add(gltf.scene);
		animate();
	  });

	  let floor = new THREE.Mesh(
	  new THREE.BoxBufferGeometry(100, 0.1, 100),
	  new THREE.MeshPhongMaterial({ color: 'black'})
	);
	floor.isDraggable = false;
	scene.add(floor);
  }
	function animate() {
	  renderer.render(scene,camera);
	  requestAnimationFrame(animate);
	}
	car();
  </script>
  
</body>
</html>