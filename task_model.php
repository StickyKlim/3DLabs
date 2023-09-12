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
	$result=pg_query($link, 'SELECT name, module FROM "Task" where id_task='."'".$_GET['id']."'");
	while ($row = pg_fetch_row($result)) {
		echo "<h1>".$row[1].": ".$row[0]."</h1>";
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


<div name="main">
<?php 
echo '<div class="set">';
include ("base.php");
if(isset($_GET['id'])){
	$result=pg_query($link, 'SELECT descript FROM "Task" where id_task='."'".$_GET['id']."'");
	while ($row = pg_fetch_row($result)) {
		echo "<h2>Описание:</h2><p>".$row[0]."</p>";
	}
}
if(isset($_GET['id'])){
	$result=pg_query($link, 'SELECT scheme, pdf FROM "TaskFiles" where id_task='."'".$_GET['id']."'");
	while ($row = pg_fetch_row($result)) {
		echo '<h2>Ход работы:</h2><br><embed src="'.$row[1].'" width="80%" height="850px"/><br>
    <a href="'.$row[0].'" download>Скачать чертеж<br>
    <img src="'.$row[0].'" width="90%" heigth="90%"><br>';
	}
}
echo '</div>';
?>
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
        // light4.position.set(-300,400,2000);
        light5 = new THREE.PointLight(0xc4c4c4,3);
        light5.position.set(-1000,600,800);
		
		// scene.add(light);
		scene.add(light2);
		scene.add(light3);
		// scene.add(light4);
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
</div>
</body>
</html>