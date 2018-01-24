window.onload = function () {
  // Expose to window namespase for testing purposes
  window.mapSVG = svgPanZoom('#svgMap', {
    zoomEnabled: true,
    controlIconsEnabled: true,
    fit: true,
    center: true,
    maxZoom: 150,
    onZoom: toggleLineWidth
    // viewportSelector: document.getElementById('svgMap').querySelector('#g4') // this option will make library to misbehave. Viewport should have no transform attribute
  });

  menu();

  function toggleLineWidth(zoomScale) {
    if (zoomScale > 5) {
      document.getElementById('container').className = ""
    } else {
      document.getElementById('container').className = "bigMap"
    }
  }

  function menu() {
    function toggleMenu() {
      var menu = document.getElementById('dropdownMenu');
      if (menu.className != "visible") {
        menu.className = "visible";
      } else {
        menu.className = "";
      }
    }
    document.getElementById('menuButton').onclick = toggleMenu;
    document.getElementById('topo').addEventListener("click", function (e) {

      var icon = e.currentTarget.firstElementChild;
      if (icon.className == "fa fa-square-o") {
        document.getElementById('topoMap').style.display = "block";
        icon.className = "fa fa-check-square-o";
      } else {
        document.getElementById('topoMap').style.display = "none";
        icon.className = "fa fa-square-o";
      }
      toggleMenu();

    });
  }

  return;
  function drawPoints() {
    var cords = [{ 'x': 19524.2578125, 'y': 1647.8675537109375 }]
    var svg = document.getElementById('svgMap')
    var imageMarkers = document.createElement('g')
    imageMarkers.setAttribute('id', 'imageMarkers')
    var circle = document.createElement('circle')
    circle.setAttribute('fill', '#7cb5ec')
    circle.setAttribute('r', '4')
    svg.appendChild(imageMarkers)
    for (var i = 0; i < cords.length; i++) {
      var cord = cords[i];
      circle.setAttribute('cx', cord.x)
      circle.setAttribute('cy', cord.y)
      imageMarkers.appendChild(circle);
    }
  }
  drawPoints()
  document.getElementById('svgMap').onclick = clicked;
  function clicked(evt) {
    var e = evt.target;
    var dim = e.getBoundingClientRect();
    var x = evt.clientX - dim.left;
    var y = evt.clientY - dim.top;
    console.log("x: " + x + " y:" + y);
  }
};
//# sourceURL=script.js

