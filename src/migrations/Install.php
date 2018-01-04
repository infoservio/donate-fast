<?php
namespace infoservio\donatefast\migrations;

use Yii;
use Craft;
use craft\db\Migration;

class Install extends Migration
{
    private $_successDonationTemplatePath = __DIR__ . '/../assets/templates/success-donation.html';

    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * This method contains the logic to be executed when applying this migration.
     * This method differs from [[up()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[up()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeUp()
    {
        // install Mail Manager Plugin
        Craft::$app->getPlugins()->installPlugin('mail-manager');

        $this->createTables();
        // $this->createIndexes();
//        $this->addForeignKeys();
        // Refresh the db schema caches
        Craft::$app->db->schema->refresh();

        $this->insertDefaultData();

        return true;
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * This method differs from [[down()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[down()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeDown()
    {
        $this->removeTables();
        return true;
    }

    // Private Methods
    // =========================================================================

    private function createTables()
    {
        if (!$this->tableExists('stripe_donation_charge')) {
            $this->createTable('stripe_donation_charge', [
                'id' => $this->primaryKey(),
                'chargeId' => $this->string(50),
                'cardId' => $this->integer(),
                'amount' => $this->float(),
                'amountRefunded' => $this->float(),
                'balanceTransaction' => $this->string(50),
                'currency' => $this->string(10),
                'projectId' => $this->integer()->null(),
                'projectName' => $this->string(255)->null(),
                'clientIp' => $this->string(30),
                'fraudDetails' => $this->text()->null(),
                'failureCode' => $this->string(255)->null(),
                'failureMessage' => $this->text()->null(),
                'created' => $this->integer(),
                'dateCreated' => $this->date(),
                'dateUpdated' => $this->date(),
                'uid' => $this->text()
            ]);
        }

        if (!$this->tableExists('stripe_donation_card')) {
            $this->createTable('stripe_donation_card', [
                'id' => $this->primaryKey(),
                'tokenId' => $this->string(50),
                'customerId' => $this->integer(),
                'last4' => $this->string(4),
                'cardType' => $this->string(20),
                'expMonth' => $this->integer(),
                'expYear' => $this->integer(),
                'customerLocation' => $this->string(2)->null(),
                'fingerprint' => $this->string(36),
                'dateCreated' => $this->date(),
                'dateUpdated' => $this->date(),
                'uid' => $this->text()
            ]);
        }

        if (!$this->tableExists('stripe_donation_customer')) {
            $this->createTable('stripe_donation_customer', [
                'id' => $this->primaryKey(),
                'customerId' => $this->string(36),
                'email' => $this->string(50),
                'phone' => $this->string(50),
                'description' => $this->string(255),
                'dateCreated' => $this->date(),
                'dateUpdated' => $this->date(),
                'uid' => $this->text()
            ]);
        }

        if (!$this->tableExists('stripe_donation_log')) {
            $this->createTable('stripe_donation_log', [
                'id' => $this->primaryKey(),
                'pid' => $this->integer(),
                'culprit' => $this->integer(),
                'category' => $this->text(),
                'method' => $this->text(),
                'message' => $this->text(),
                'errors' => $this->text(),
                'dateCreated' => $this->date(),
                'dateUpdated' => $this->date(),
                'uid' => $this->text()
            ]);
        }

        if (!$this->tableExists('stripe_donation_setting')) {
            $this->createTable('stripe_donation_setting', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->unique(),
                'value' => $this->text(),
                'dateCreated' => $this->date(),
                'dateUpdated' => $this->date(),
                'uid' => $this->text()
            ]);

            $this->insertDonationsSettingsDefaultValue();
        }
    }

    private function addForeignKeys()
    {
        $this->addForeignKey(
            'fk-donate-fast-charge-card',
            'stripe_donation_charge',
            'cardId',
            'stripe_donation_card',
            'id'
        );

        $this->addForeignKey(
            'fk-donate-fast-card-customer',
            'stripe_donation_card',
            'customerId',
            'stripe_donation_customer',
            'id'
        );
    }

    private function removeTables()
    {
//        $this->dropTableIfExists('stripe_donation_setting');
    }

    private function insertDefaultData()
    {
        $this->insertMailManagerTemplate();
    }


    private function insertDonationsSettingsDefaultValue()
    {
        $this->insert('stripe_donation_setting', [
            'name' => 'successMessage',
            'value' => 'Success Message'
        ]);

        $this->insert('stripe_donation_setting', [
            'name' => 'errorMessage',
            'value' => 'Error Message'
        ]);

        $this->insert('stripe_donation_setting', [
            'name' => 'companyName',
            'value' => 'Non-profit company Name'
        ]);

        $this->insert('stripe_donation_setting', [
            'name' => 'companyTelephone',
            'value' => 'Telephone number'
        ]);

        $this->insert('stripe_donation_setting', [
            'name' => 'companyAddress',
            'value' => 'Address'
        ]);

        $this->insert('stripe_donation_setting', [
            'name' => 'companyEmail',
            'value' => 'company@email.com'
        ]);
    }

    private function insertMailManagerTemplate()
    {
        $content = file_get_contents($this->_successDonationTemplatePath);

        try {
            $this->insert('mailmanager_template', [
                'name' => 'Success Donation Email',
                'slug' => 'success-donation',
                'subject' => 'Thank you for your donation.',
                'template' => $content
            ]);
        } catch (\Exception $e) {
            // test
        }
    }

    private function tableExists($table)
    {
        return (Yii::$app->db->schema->getTableSchema($table) !== null);
    }
}

