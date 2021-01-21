<?php

namespace Drupal\simplytest_ocd\Plugin\OneClickDemo;

/**
 * Provides one click demo for commerce.
 *
 * @OneClickDemo(
 *   id = "oneclickdemo_commerce",
 *   title = @Translation("Drupal Commerce Demo"),
 *   base_preview_name = "commerce"
 * )
 */
class Commerce extends Drupal8Base {

  public function getSetupCommands(array $parameters): array {
    return [
      'docker-php-ext-install bcmath',
      'rm -rf "${DOCROOT}"',
    ];
  }

  public function getDownloadCommands($parameters): array {
    $commands = [
      // @todo the base preview doesn't have the `commerce` dir?
      'cd "${TUGBOAT_ROOT}" && composer create-project drupalcommerce/demo-project commerce --stability dev --no-interaction',
      'ln -snf "${TUGBOAT_ROOT}/commerce/web" "${DOCROOT}"'
    ];
    // $commands[] = 'cd "${TUGBOAT_ROOT}"/commerce && composer update --no-ansi --no-dev';
    return $commands;
  }

  public function getPatchingCommands($parameters): array {
    return [];
  }

  public function getInstallingCommands($parameters): array {
    $commands = [];
    $commands[] = 'php -d memory_limit=-1 commerce/bin/drush si --db-url=mysql://tugboat:tugboat@mysql:3306/tugboat --account-name=admin --account-pass=admin -y';
    return $commands;
  }

}
