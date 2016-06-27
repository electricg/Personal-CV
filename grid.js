var GridSystem = function(grids, color, coordinates) {
  var $ = document.querySelectorAll.bind(document);
  var $$ = document.querySelector.bind(document);
  Element.prototype.on = Element.prototype.addEventListener;
  
  grids = grids || [];
  color = color || 'red';
  coordinates = coordinates || '';

  var shadow = 'px 0 currentColor';
  var $body = document.body;
  
  var $gridWrapper;
  var $gridButton;
  
  var addStyle = function(style, $parent) {
    var $style = document.createElement('style');
    $style.setAttribute('scoped', '');
    $style.innerHTML = style;
    if ($parent) {
      $parent.appendChild($style);
    }
    return $style;
  };
  
  var createGrid = function() {
    $gridWrapper = document.createElement('grid-wrapper');
    addStyle(
      'grid-wrapper * {' +
      '  border-left: 1px solid currentColor;' +
      '  bottom: 0;' +
      '  color: ' + color + ';' +
      '  display: none;' +
      '  position: fixed;' +
      '  top: 0;' +
      '}', $gridWrapper);
    
    for (var index = 0; index < grids.length; index++) {
      addGrid(grids[index]);
    }
  };
  
  var createButton = function() {
    var gridButtonCoordinatesV = 'top';
    var gridButtonCoordinatesH = 'left';
    if (coordinates.indexOf('right') !== -1) {
      gridButtonCoordinatesH = 'right';
    }
    if (coordinates.indexOf('bottom') !== -1) {
      gridButtonCoordinatesV = 'bottom';
    }
    $gridButton = document.createElement('grid-button');
    addStyle(
      'grid-button {' +
      '  background: ' + color + ';' +
      '  box-shadow: inset 0 0 0 5px ' + color + ';' +
      '  cursor: pointer;' +
      '  height: 30px;' +
      '  position: fixed;' +
      '  width: 30px;' +
      '  ' + gridButtonCoordinatesV + ': 0;' +
      '  ' + gridButtonCoordinatesH + ': 0;' +
      '}', $gridButton);
    $gridButton.on('click', toggle);
  };
  
  var init = function() {
    $body.appendChild($gridWrapper);
    $body.appendChild($gridButton);
  };
  
  var addGrid = function(grid) {
    var mq = grid.shift();
    var $el = document.createElement('grid-system-' + mq);
    var c = 0;
    var s = [];
    if (typeof grid[grid.length - 1] === 'string') {
      $el.style.color = grid.pop();
    }
    for (var i = 0; i < grid.length; i++) {
      if (typeof grid[i] === 'number') {
        c += grid[i];
        s.push(c + shadow);
      }
      else if (Array.isArray(grid[i])) {
        var arrC = grid[i][1];
        var arrN = grid[i][0];
        for (var m = 0; m < arrC; m++) {
          for (var p = 0; p < arrN.length; p++) {
            c += arrN[p];
            s.push(c + shadow);
          }
        }
      }
    }
    $el.style.boxShadow = s.join(',');
    $el.style.left = 'calc(50% - ' + c + 'px/2)';
    addStyle(
      '@media (min-width: ' + mq + 'px) {' +
      'grid-wrapper * {' +
      '  display: none;' +
      '}' +
      '  grid-system-' + mq + ' {' +
      '    display: block;' +
      '  }' +
      '}', $el);
    $gridWrapper.appendChild($el);
  };
  
  var removeGrid = function(mq) {
    $gridWrapper.removeChild($$('grid-system-' + mq));
  };
  
  var removeAll = function() {
    $body.removeChild($gridWrapper);
    $body.removeChild($gridButton);
  };
  
  var show = function() {
    $gridWrapper.style.display = '';
    $gridButton.style.background = '';
  };
  
  var hide = function() {
    $gridWrapper.style.display = 'none';
    $gridButton.style.background = 'transparent';
  };
  
  var toggle = function() {
    if ($gridWrapper.style.display === 'none') {
      show();
    }
    else {
      hide();
    }
  };
  
  this.init = function() {
    init();
  };
  this.add = function(grid) {
    // to refine
    addGrid(grid);
  };
  this.remove = function(mq) {
    removeGrid(mq);
  };
  this.delete = function() {
    removeAll();
  };
  this.show = function() {
    show();
  };
  this.hide = function() {
    hide();
  };
  this.toggle = function() {
    toggle();
  };
  
  createGrid();
  createButton();
  
  init();
  
  return this;
};


var grids = [
  [  320, 20, 130, 20, 130, 20, 'green'],
  [  640, 26, 210, 20, 470, 26],
  [ 1024, 13, 20, [[127, 40], 5], 127, 20, 13, 'blue']
];
var color = 'red';
var coordinates = 'top right';
var grid = new GridSystem(grids, color, coordinates);
