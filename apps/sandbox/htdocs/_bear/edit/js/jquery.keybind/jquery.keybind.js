
(function($) {

var count = function(obj) {
  var result = 0;
  $.each(obj, function() { ++result; });
  return result;
};

function KeybindTree() {
  this.root = {};
}
KeybindTree.prototype.add = function(keys, handler) {
  var node = this.root;
  var length = keys.length;
  $.each(keys.slice(0, length - 1), function() {
    var key = this.toString();
    if(key in node) {
      node = node[key];
    }
    else {
      node = node[key] = {};
    }
  });
  node[keys[length - 1].toString()] = handler;
};
KeybindTree.prototype.find = function(keys) {
  var result = true;
  var node = this.root;
  $.each(keys, function() {
    var key = this.toString();
    if(key in node) {
      node = node[key.toString()];
      return true;
    }
    else {
      result = false;
      return false;
    }
  });
  if(!result) {
    return false;
  }
  if($.isFunction(node)) {
    return node;
  }
  return true;
};
KeybindTree.prototype.remove = function(keys) {
  var nodes = [];
  var node = this.root;
  $.each(keys, function() {
    var key = this.toString();
    if(key in node) {
      nodes.push(node);
      node = node[key];
      return true;
    }
    else {
      return false;
    }
  });
  var length = keys.length;
  if(nodes.length != length) {
    return false;
  }
  $.each(nodes.reverse(), function(i) {
    var key = keys[keys.length - i - 1].toString();
    delete this[key];
    if(count(this) != 0) {
      return false;
    }
    return true;
  });
  return true;
};

var specialKeyCodes = {
  BACKSPACE: 8, TAB: 9, RETURN: 13, SHIFT: 16, CONTROL: 17, ALT: 18,
  PAUSE: 19, CAPSLOCK: 20, ESCAPE: 27, SPACE: 32, PAGEUP: 33, PAGEDOWN: 34,
  END: 35, HOME: 36, LEFT: 37, UP: 38, RIGHT: 39, DOWN: 40,
  INSERT: 45, DELETE: 46, 
  F1: 112, F2: 113, F3: 114, F4: 115, F5: 116, F6: 117,
  F7: 118, F8: 119, F9: 120, F10: 121, F11: 122, F12: 123,
  NUMLOCK: 144, SCROLL: 145, "/": 191, META: 224,
  "[": 219, "]": 221, ";": 187, "@": 192, ":": 186,
  "-": 189, "\\": 226, ",": 188, ".": 190, "^": 222
};

function Key() {
  if(arguments.length == 1) {
    var parts = arguments[0].split('-');
    var modifiers = parts.length > 1 ? parts.slice(0, parts.length - 1) : [];
    var key = parts[parts.length - 1].toUpperCase();
    var keyCode = null;
    var shiftKey = false;
    var ctrlKey = false;
    var altKey = false;
    if(key.match(/^[A-Z0-9]$/)) {
      keyCode = key.charCodeAt(0);
    }
    else if(key in specialKeyCodes) {
      keyCode = specialKeyCodes[key];
    }
    $.each(modifiers, function() {
      switch(this.charAt(0).toUpperCase()) {
      case 'S':
        shiftKey = true;
        break;
      case 'C':
        ctrlKey = true;
        break;
      case 'A':
        altKey = true;
        break;
      default:
        break;
      }
    });
    this.keyCode = keyCode;
    this.shiftKey = shiftKey;
    this.ctrlKey = ctrlKey;
    this.altKey = altKey;
  }
  else {
    this.keyCode = arguments[0];
    this.shiftKey = arguments[1];
    this.ctrlKey = arguments[2];
    this.altKey = arguments[3];
  }
}
Key.prototype = {};
Key.prototype.equals = function(rhs) {
  return this.keyCode == rhs.keyCode && 
    this.shiftKey == rhs.shiftKey &&
    this.ctrlKey == rhs.ctrlKey &&
    this.altKey == rhs.altKey;
};
Key.prototype.toString = function() {
  var a = [];
  if(this.altKey) {
    a.push('A');
  }
  if(this.ctrlKey) {
    a.push('C');
  }
  if(this.shiftKey) {
    a.push('S');
  }
  a.push(String.fromCharCode(this.keyCode));
  return a.join('-');
};

Key.parse = function(keybind) {
  return $.map(keybind.split(' '), function(s) { return new Key(s); });
};

var dataId = function(handle) { 
  return 'jquery.keybind.' + handle.type;
};

var addHandler = function(handle) {
  if(typeof(handle.data) !== 'string') {
    return;
  }

  handle.guid = handle.handler.guid;

  var keys = Key.parse(handle.data);
  var element = this;

  var id = dataId(handle);
  var data = $.data(this, id);

  if(data === undefined) {
    data = {
      tree: new KeybindTree(),
      buffer: [],
      handles: [ handle ]
    };
    $.data(this, id, data);
    data.tree.add(keys, handle.handler);
    handle.handler = function(e) {
      data.buffer.push(new Key(e.keyCode, e.shiftKey, e.ctrlKey, e.altKey));
      var result = true;
      var currentHandler = data.tree.find(data.buffer);
      if(!currentHandler) {
        data.buffer = [];
      }
      else if($.isFunction(currentHandler)) {
        result = currentHandler.call(element, e);
        data.buffer = [];
      }
      else {
        result = false;
      }
      return result;
    };
  }
  else {
    data.handles.push(handle);
    data.tree.add(keys, handle.handler);
    handle.handler = $.noop;
  }
};

var removeHandler = function(handle) {
  if(typeof(handle.data) !== 'string') {
    return;
  }

  var id = dataId(handle);
  var data = $.data(this, id);
  if(data !== undefined) {
    var keys = Key.parse(handle.data);
    data.tree.remove(keys);
  }
  if(handle.guid == data.handles[0].guid) {
    var primary = data.handles.shift();
    if(data.handles.length > 0) {
      data.handles[0].handler = primary.handler;
    }
    else {
      $.data(this, id, undefined);
    }
  }
};

var special = {
  add: addHandler,
  remove: removeHandler
};
$.each(['keydown', 'keyup'], function() {
  $.event.special[this] = special;
});

$.fn.keybind = function(type, options) {
  if(options === undefined) {
    options = type;
    type = 'keydown';
  }
  for(var key in options) {
    $(this).bind(type, key, options[key]);
  }
};

})(jQuery);

