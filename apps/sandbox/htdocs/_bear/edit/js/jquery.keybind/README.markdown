# jQuery.Keybind

jQuery.Keybind is a jQuery plugin to handle multi-stroke key bindings.

## Example

### Basic

    $(window).bind('keydown', 'j', function() { alert('j'); });
    $(window).bind('keydown', 'k', function() { alert('k'); });

### Batch

    $(window).keybind('keydown', {
      'j': function() { alert('j'); },
      'k': function() { alert('k'); }
    });

### Modifiers

    $(window).keybind('keydown', {
      'C-j': function() { alert('Ctrl + j'); },
      'S-j': function() { alert('Shift + j'); },
      'A-j': function() { alert('Alt + j'); },
      'C-S-j': function() { alert('Ctrl + Shift + j'); }
    });

### Multi-stroke

    $(window).keybind('keydown', {
      'C-x C-c': funcion() { alert('Ctrl + X -> Ctrl + C'); },
      'C-x C-f': funcion() { alert('Ctrl + X -> Ctrl + F'); }
    });

## License

jQuery.Keybind is licensed under the MIT license.

### The MIT License

Copyright (c) 2010-2011 mono

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

