[![CI](https://github.com/gesinn-it-pub/ConfIDentSkin/actions/workflows/ci.yml/badge.svg)](https://github.com/gesinn-it-pub/ConfIDentSkin/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/gesinn-it-pub/ConfIDentSkin/branch/main/graph/badge.svg?token=XYOGLN5ANJ)](https://codecov.io/gh/gesinn-it-pub/ConfIDentSkin)

# confident-skin
MediaWiki skin for the ConfIDent project. It can be seen in action on https://www.confident-conference.org/.

This skin is implemented as MediaWiki extension extending https://www.mediawiki.org/wiki/Skin:Chameleon.

## Requirements
* MediaWiki 1.35+
* Skin:Chameleon 4.1.0+

## Getting started
* Download and place the file(s) in a directory called `ConfIDentSkin` in your `extensions/` folder.
* Add the following code at the bottom of your LocalSettings.php:
```
wfLoadExtension( 'ConfIDentSkin' );
```
* Done – Navigate to `Special:Version` on your wiki to verify that the extension is successfully installed.

## Testing
The code is tested using Github Actions CI. See [ci.yml](.github/workflows/ci.yml) for details.
