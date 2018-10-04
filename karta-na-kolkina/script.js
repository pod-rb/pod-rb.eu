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

  window.mapSVG2 = svgPanZoom('#svgRazrez', {
    zoomEnabled: true,
    controlIconsEnabled: true,
    fit: true,
    center: true,
    maxZoom: 150,
    onZoom: toggleLineWidthVertical
    // viewportSelector: document.getElementById('svgMap').querySelector('#g4') // this option will make library to misbehave. Viewport should have no transform attribute
  });
  document.getElementById('svgRazrez').style.display = "none";
  // var embed = document.createElement('embed');
  // embed.setAttribute('style', 'width: 100%; height: 100%; border: 1px solid black;');
  // embed.setAttribute('type', 'image/svg+xml');
  // embed.setAttribute('src', "Kolkina-razrez.svg");
  // embed.setAttribute('id', "svgRazrez");

  // document.getElementById('container').appendChild(embed)

  // lastEventListener = function () {
  //   svgPanZoom(embed, {
  //     zoomEnabled: true,
  //     controlIconsEnabled: true,
  //     fit: true,
  //     center: true,
  //     maxZoom: 150,
  //   });
  // }
  // embed.addEventListener('load', lastEventListener)

  menu();

  function toggleLineWidth(zoomScale) {
    // var isTopoOn = document.getElementById('topo').firstElementChild.className == 'fa fa-check-square-o'
    if (zoomScale > 2) {
      document.getElementById('container').className = ""
    } else {
      document.getElementById('container').className = "bigMap"
    }
  }

  function toggleLineWidthVertical(zoomScale) {
    if (zoomScale > 2) {
      document.getElementById('container').className = "verticalMap"
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

    Array.from(document.querySelectorAll('#dropdownMenu button')).forEach(function (button) {
      button.addEventListener("click", function (e) {
        var icon = e.currentTarget.firstElementChild;
        if (icon.className == "fa fa-square-o") {
          icon.className = "fa fa-check-square-o";
        } else {
          icon.className = "fa fa-square-o";
        }

        if (e.target.id == "topo" || e.currentTarget.id == "topo") {
          if (icon.className == "fa fa-square-o") {
            document.getElementById('topoMap').style.display = "none";
          } else {
            document.getElementById('topoMap').style.display = "block";
          }
        }

        if (e.target.id == "vertical" || e.currentTarget.id == "vertical") {
          if (icon.className == "fa fa-square-o") {
            document.getElementById('topoMap').style.display = "block";
            document.getElementById('svgMap').style.display = "block";
            document.getElementById('svgRazrez').style.display = "none";
          } else {
            document.getElementById('topoMap').style.display = "none";
            document.getElementById('svgMap').style.display = "none";
            document.getElementById('svgRazrez').style.display = "block";
          }
        }
        toggleLineWidth(mapSVG.getZoom())
        toggleMenu();
      });
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

