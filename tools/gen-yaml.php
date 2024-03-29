<?php
declare(strict_types=1);

$oss = ['bullseye', 'buster'];
$versions = ['8.1', '8.0', '7.4'];
$sapis = ['cli', 'apache', 'fpm'];

?>
# This file was generated by tools/gen-yaml.php. Please do not modify it.
aliases:
  tag: &tagBase
    os: "linux"
    architecture: "amd64"

images:
  - template:
      src: Dockerfile.tpl
      dest: Dockerfile
    command: |
      git checkout -b branch-{{.Tag}}
      git add {{.TemplateDestination}}
      git commit -m "update to {{.Tag}}"
      git push origin :{{.Tag}}
      git tag {{.Tag}}
      git push origin {{.Tag}}
      git checkout master
    base:
      provider: dockerhub
      image: library/php
      tags:
<?php
    foreach ($versions as $version) {
        foreach ($sapis as $sapi) {
            foreach ($oss as $os) {
?>
        - <<: *tagBase
          pattern: "^<?= $version ?>.[0-9]+\\-<?= $sapi ?>\\-<?= $os ?>$"
          version: ^<?= $version ?>.0
        - <<: *tagBase
          pattern: "^<?= $version ?>\\-<?= $sapi ?>\\-<?= $os ?>$"
          version: ^<?= $version ?>
<?php
                echo PHP_EOL;
            }
        }
    }
?>
<?php
    foreach ($sapis as $sapi) {
        foreach ($oss as $os) {
?>
        - <<: *tagBase
          pattern: "^8\\-<?= $sapi ?>\\-<?= $os ?>$"
          version: 8
        - <<: *tagBase
          pattern: "^7\\-<?= $sapi ?>\\-<?= $os ?>$"
          version: 7
<?php
        }
    }
?>
        - <<: *tagBase
          pattern: "^7.3.[0-9]+\\-cli\\-buster$"
          version: ^7.3.0
        - <<: *tagBase
          pattern: "^7.3\\-cli\\-buster$"
          version: 7.3
        - <<: *tagBase
          pattern: "^7.2.[0-9]+\\-cli\\-buster$"
          version: ^7.2.0
        - <<: *tagBase
          pattern: "^7.2\\-cli\\-buster$"
          version: 7.2
        - <<: *tagBase
          pattern: "^7.1.[0-9]+\\-cli\\-buster$"
          version: ^7.1.0
        - <<: *tagBase
          pattern: "^7.1\\-cli\\-buster$"
          version: 7.1
        - <<: *tagBase
          pattern: "^7.3.[0-9]+\\-fpm\\-buster$"
          version: ^7.3.0
        - <<: *tagBase
          pattern: "^7.3\\-fpm\\-buster$"
          version: 7.3
        - <<: *tagBase
          pattern: "^7.2.[0-9]+\\-fpm\\-buster$"
          version: ^7.2.0
        - <<: *tagBase
          pattern: "^7.2\\-fpm\\-buster$"
          version: 7.2
        - <<: *tagBase
          pattern: "^7.1.[0-9]+\\-fpm\\-buster$"
          version: ^7.1.0
        - <<: *tagBase
          pattern: "^7.1\\-fpm\\-buster$"
          version: 7.1
        - <<: *tagBase
          pattern: "^7.3.[0-9]+\\-apache\\-buster$"
          version: ^7.3.0
        - <<: *tagBase
          pattern: "^7.3\\-apache\\-buster$"
          version: 7.3
        - <<: *tagBase
          pattern: "^7.2.[0-9]+\\-apache\\-buster$"
          version: ^7.2.0
        - <<: *tagBase
          pattern: "^7.2\\-apache\\-buster$"
          version: 7.2
        - <<: *tagBase
          pattern: "^7.1.[0-9]+\\-apache\\-buster$"
          version: ^7.1.0
        - <<: *tagBase
          pattern: "^7.1\\-apache\\-buster$"
          version: 7.1
