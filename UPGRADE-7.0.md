# UPGRADE FROM 6.x to 7.0

### Breaking Changes:

+ Support for PHP 8.1 removed. Only PHP 8.2, 8.3, 8.4, and 8.5 are supported.
+ If your project is still running on PHP 8.1, upgrade the runtime before updating this package to v7.0.

### Notes:

+ The release process now writes the resolved SemVer version into `composer.json` before the matching git tag is created.
+ GitHub automation was expanded with consolidated CI, Dependabot auto-merge, and PR labeling.
