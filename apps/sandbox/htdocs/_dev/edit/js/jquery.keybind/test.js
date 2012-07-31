(function($) {
$(function() {

  test('bind', function() {
    expect(2);

    var target = $('<div />');
    deepEqual(target.bind('keydown', 'A', $.noop), target);
    deepEqual(target.bind('keyup', 'A', $.noop), target);
  });

  test('unbind', function() {
    expect(2);

    var target = $('<div />');
    target.bind('keydown', 'A', $.noop);
    target.bind('keyup', 'A', $.noop);
    deepEqual(target.unbind('keydown', 'A', $.noop), target);
    deepEqual(target.unbind('keyup', 'A', $.noop), target);
  });

  test('trigger', function() {
    expect(1);

    var target = $('<div />');
    var f = function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'A');
    };
    target.bind('keydown', 'A', f);

    var e = $.Event('keydown');
    e.keyCode = 'A'.charCodeAt();
    target.trigger(e);

    target.unbind('keydown', f).trigger(e);
  });

  test('shiftKey', function() {
    expect(2);

    var target = $('<div />');
    target.bind('keydown', 'S-A', function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'A');
      ok(e.shiftKey, 'shiftKey');
    });
    var e = $.Event('keydown');
    e.keyCode = 'A'.charCodeAt();
    e.shiftKey = true;
    target.trigger(e);
  });

  test('ctrlKey', function() {
    expect(2);

    var target = $('<div />');
    target.bind('keydown', 'C-A', function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'A');
      ok(e.ctrlKey, 'ctrlKey');
    });
    var e = $.Event('keydown');
    e.keyCode = 'A'.charCodeAt();
    e.ctrlKey = true;
    target.trigger(e);
  });

  test('altKey', function() {
    expect(2);

    var target = $('<div />');
    target.bind('keydown', 'A-A', function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'A');
      ok(e.altKey, 'altKey');
    });
    var e = $.Event('keydown');
    e.keyCode = 'A'.charCodeAt();
    e.altKey = true;
    target.trigger(e);
  });

  test('multiple strokes', function() {
    expect(1);

    var target = $('<div />');
    target.bind('keydown', 'A B C', function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'C');
    });

    var e1 = $.Event('keydown');
    e1.keyCode = 'A'.charCodeAt();
    var e2 = $.Event('keydown');
    e2.keyCode = 'B'.charCodeAt();
    var e3 = $.Event('keydown');
    e3.keyCode = 'C'.charCodeAt();
    target.trigger(e1);
    target.trigger(e2);
    target.trigger(e3);
  });

  test('branch', function() {
    expect(1);

    var target = $('<div />');
    target.bind('keydown', 'A B', function(e) {
      deepEqual(String.fromCharCode(e.keyCode), 'B');
    });
    target.bind('keydown', 'A C', function(e) {
      ok(false);
    });

    var e1 = $.Event('keydown');
    e1.keyCode = 'A'.charCodeAt();
    var e2 = $.Event('keydown');
    e2.keyCode = 'B'.charCodeAt();
    target.trigger(e1);
    target.trigger(e2);
  });

});
})(jQuery);

