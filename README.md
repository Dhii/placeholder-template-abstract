# Dhii - Placeholder Template - Abstract

[![Build Status](https://travis-ci.org/Dhii/placeholder-template-abstract.svg?branch=develop)](https://travis-ci.org/Dhii/placeholder-template-abstract)
[![Code Climate](https://codeclimate.com/github/Dhii/placeholder-template-abstract/badges/gpa.svg)](https://codeclimate.com/github/Dhii/placeholder-template-abstract)
[![Test Coverage](https://codeclimate.com/github/Dhii/placeholder-template-abstract/badges/coverage.svg)](https://codeclimate.com/github/Dhii/placeholder-template-abstract/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/placeholder-template-abstract/version)](https://packagist.org/packages/dhii/placeholder-template-abstract)
[![Latest Unstable Version](https://poser.pugx.org/dhii/placeholder-template-abstract/v/unstable)](https://packagist.org/packages/dhii/placeholder-template-abstract)
[![This package complies with Dhii standards](https://img.shields.io/badge/Dhii-Compliant-green.svg?style=flat-square)][Dhii]

## Details
Abstract functionality for working with templates that use placeholders.

### Traits
- [`ReplaceTokensCapableTrait`] - Replaces tokens in a string with their corresponding values from a container,
according to the token start and end. Allows normalization of token key into format used in container.
- [`NormalizeTokenDelimiterCapableTrait`] - Normalizes token delimiters, like token start and end, making sure value type is correct.
- [`TokenStartAwareTrait`] - Awareness of a token start delimiter.
- [`TokenEndAwareTrait`] - Awareness of a token end delimiter.
- [`DefaultPlaceholderValueAwareTrait`] - Awareness of a default placeholder value.
- [`PlaceholderTemplateAwareCapableTrait`] - Awareness of a placeholder template source.


[Dhii]: https://github.com/Dhii/dhii

[`ReplaceTokensCapableTrait`]:                          src/ReplaceTokensCapableTrait.php
[`NormalizeTokenDelimiterCapableTrait`]:                src/NormalizeTokenDelimiterCapableTrait.php
[`TokenStartAwareTrait`]:                               src/TokenStartAwareTrait.php
[`TokenEndAwareTrait`]:                                 src/TokenEndAwareTrait.php
[`DefaultPlaceholderValueAwareTrait`]:                  src/DefaultPlaceholderValueAwareTrait.php
[`PlaceholderTemplateAwareCapableTrait`]:               src/PlaceholderTemplateAwareCapableTrait.php
