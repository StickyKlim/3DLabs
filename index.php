<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Главная страница </title>
</head>
<script src="threejs.org/build/three.js"></script>
<script src="threejs.org/examples/js/loaders/GLTFLoader.js"></script>
<script src="threejs.org/examples/js/controls/OrbitControls.js"></script>
<body>
<h1> Кафедра информационных технологий </h1>

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
<h2>Web-приложение является частью визуализации курса "Мультимедийные технологии"</h2>


<script type="module">
import { OrbitControls } from "https://cdn.skypack.dev/three@0.132.2/examples/jsm/controls/OrbitControls.js";

 <?php
include ("base.php");
  $result=pg_query($link, 'SELECT * FROM "Settings" where id_task=1');
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
  scene,
  camera,
  renderer,
  controls,
  clickMouse,
  moveMouse,
  raycaster,
  draggableObject;

// Create Scene and lights
function init() {
  // SCENE
  scene = new THREE.Scene();
  scene.background = new THREE.Color(0xbfd1e5);

  // CAMERA
  camera = new THREE.PerspectiveCamera(
    50,
    window.innerWidth / window.innerHeight,
    0.1,
    5000
  );
  camera.position.set(0, 50, 100);

  // RENDERER
  renderer = new THREE.WebGLRenderer({ antialias: true });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(1600, 900);
  renderer.shadowMap.enabled = true;
  document.body.appendChild(renderer.domElement);

  // CAMERA MOVEMENT CONTROLS
  controls = new OrbitControls(camera, renderer.domElement);
  controls.target.set(0, 10, 0);
  controls.enableDamping = true;
  controls.update();

  // LIGHTS
  let ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
  let directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
  directionalLight.position.set(-30, 50, 150);
  scene.add(ambientLight);
  scene.add(directionalLight);

  // RAYCASTING (mouse functionality)
  raycaster = new THREE.Raycaster();
  clickMouse = new THREE.Vector2();
  moveMouse = new THREE.Vector2();

  // FLOOR
  let floor = new THREE.Mesh(
    new THREE.BoxBufferGeometry(100, 0.1, 100),
    new THREE.MeshPhongMaterial({ color: 696969 })
  );
  floor.isDraggable = false;
  scene.add(floor);
}

function addCylinder(rad1, rad2, m1, m2, posx, posy, posz) {
  let object = new THREE.Mesh(
    new THREE.CylinderBufferGeometry(rad1, rad2, m1, m2),
    new THREE.MeshPhongMaterial({ color: "#FF0000" })
  );
  object.position.set(posx, posy, posz);
  object.isDraggable = true;
  scene.add(object);
}

function addSphere(rad, m1, m2, posx, posy, posz) {
  let object = new THREE.Mesh(
    new THREE.SphereBufferGeometry( rad, m1, m2),
    new THREE.MeshPhongMaterial({ color: "#FF0000" })
  );
  object.position.set(posx, posy, posz);
  object.isDraggable = true;
  scene.add(object);
}

function dragObject() {
  // If 'holding' an object, move the object
  if (draggableObject) {
    raycaster.setFromCamera(moveMouse, camera);
    // `found` is the metadata of the objects, not the objetcs themsevles
    const found = raycaster.intersectObjects(scene.children);
    if (found.length) {
      for (let obj3d of found) {
        if (!obj3d.object.isDraggablee) {
          draggableObject.position.x = obj3d.point.x;
          draggableObject.position.z = obj3d.point.z;
          break;
        }
      }
    }
  }
}

// Allows user to pick up and drop objects on-click events
window.addEventListener("click", (event) => {
  // If 'holding' object on-click, set container to <undefined> to 'drop' the object.
  if (draggableObject) {
    draggableObject = undefined;
    return;
  }

  // If NOT 'holding' object on-click, set container to <object> to 'pickup' the object.
  clickMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  clickMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
  raycaster.setFromCamera(clickMouse, camera);
  const found = raycaster.intersectObjects(scene.children, true);
  if (found.length && found[0].object.isDraggable) {
    draggableObject = found[0].object;
  }
});

// Constantly updates the mouse location for use in `dragObject()`
window.addEventListener("mousemove", (event) => {
  dragObject(); // Updates the object's postion every time the mouse moves
  moveMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  moveMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
});

// Recursive function to render the scene
function animate() {
  controls.update();
  renderer.render(scene, camera);
  requestAnimationFrame(animate);
}

// Re-renders the scene upon window resize
function onWindowResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
}

// Start the program
(function () {
    window.addEventListener("resize", onWindowResize, false);
    init();
    addCylinder(2,10,10,10,0,5,0);
    addCylinder(6,6,12,12,-15,6,20);
    addSphere(4,32,32,12,4,4);
    addSphere(8,8,8,-20,8,-6);
    // objectLoad();    
    animate();
    //   addObject()
})();

  </script>

</div>
</body>
</html>