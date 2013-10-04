# Scribble 2.0
Scribble has been completely rewritten using the [CakePHP](http://cakephp.org/) MVC framework. All features that are present in the previous version is still available. A few new features has also been included.

## Libraries
Scribble 2.0 is powered by the following open source libraries/projects:

- [Animate.css](https://github.com/daneden/animate.css)
- [Bootstrap](http://getbootstrap.com/)
- [Google Charts](https://developers.google.com/chart/)
- [jQuery.caret.js](https://github.com/garyharan/jQuery-caret-utilities)
- [jQuery](http://jquery.com/)
- [MathJax](http://www.mathjax.org/)
- [Zocial CSS Social Buttons](http://zocial.smcllns.com/)

Also, one of the key features - LaTeX selector can be considered a side project and its source is available [here](https://github.com/yihangho/latex-editor).

## Requirements
Scribble 2.0 is developed and tested with the following:

- Apache 2.2.22
- PHP 5.5.3
- MySQL 5.6.13

I am not very sure if these are strictly required - chances are they don't. However, I am quite sure that PHP >= 5.4 is required as [function array dereferencing](http://www.php.net/manual/en/migration54.new-features.php) is used.

## Change Log
This change log will only record the changes between versions pushed to production. As a result, there will be quite a few commits in between them. Refer to individual commit for more information.

- October 4, 2013 (abdef58732a916f7e015258c3fab0fcaab3995f9)

  - Add cronjob to update and record amount of Scribbles

- September 27, 2013 (77aff3013f8ca53c21254d22a076fe14befb3ced)

  - Users are now able to login via Facebook or Google+
  - Logged in users can keep track of the Scribbles that they have created

- September 16, 2013 (18839d18ca665d82e4e2e9e260b1e4f18283185a)

  - Initial release
  - Introduce LaTeX selector
  - Introduce share to Facebook, Google+ and Twitter
