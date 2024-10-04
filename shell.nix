{ pkgs ? import <nixpkgs> {}}:

let
  configuredPkgs = {
    php = pkgs.php.withExtensions ({ all, enabled }: enabled ++ (with all; [ gnupg xdebug ]));
  };
in
  pkgs.mkShell {
    name = "simensen-sequence";
    packages = [
      configuredPkgs.php
      configuredPkgs.php.packages.composer
      configuredPkgs.php.packages.phive
      pkgs.gnupg
      pkgs.jetbrains.phpstorm
      pkgs.markdownlint-cli2
      pkgs.yamllint
    ];
    shellHook =
      ''
        export PATH=$(pwd)/tools:$PATH
      '';
  }
