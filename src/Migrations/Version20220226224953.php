<?php

namespace App\Migrations;

use AntiMattr\MongoDB\Migrations\AbstractMigration;
use MongoDB\Database;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20220226224953 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return "";
    }

    public function up(Database $db)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $collectionNamesForCreation = ['link', 'token', 'user'];
        $list = $db->listCollectionNames();
        $existingCollectionNames = [];
        foreach ($list as $item) {
            $existingCollectionNames[] = $item;
        }

        $collectionNames = array_diff($collectionNamesForCreation, $existingCollectionNames);

        foreach ($collectionNames as $collectionName) {
            $db->createCollection($collectionName);
        }

        $db->command(['createIndexes' => 'link', 'indexes' => [
          ['name'=> 'shortLink', 'key' => (object)['shortLink' => 1]],
          ['name'=> 'date', 'key' => (object)['date' => 1]]],
        ]);

        $db->command(['createIndexes' => 'token', 'indexes' => [
          ['name'=> 'token', 'key' => (object)['token' => 1]]
        ]]);

        $db->command([
          'collMod' => 'token',
          'validator' => ['$jsonSchema' => ['required' => [ 'user', 'token' ]]]
        ]);

        $db->command([
          'collMod' => 'link',
          'validator' => ['$jsonSchema' => ['required' => [ 'user', 'link', 'shortLink', 'date' ]]]
        ]);

        $db->command([
          'collMod' => 'user',
          'validator' => ['$jsonSchema' => ['required' => [ 'name', 'email' ]]]
        ]);
    }

    public function down(Database $db)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $db->dropCollection('link');
        $db->dropCollection('token');
        $db->dropCollection('user');
    }
}
