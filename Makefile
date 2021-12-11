.PHONY: update-yaml
update-yaml:
	php tools/gen-yaml.php > base-chaser.yaml
