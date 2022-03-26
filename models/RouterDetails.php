<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "router_details".
 *
 * @property int $id
 * @property string $sapid
 * @property string $hostname
 * @property string $loopback
 * @property string $mac_address
 * @property string $created_date
 */
class RouterDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'router_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sapid', 'hostname', 'loopback', 'mac_address'], 'required'],
            [['created_date'], 'safe'],
            [['sapid'], 'string', 'max' => 18],
            [['hostname'], 'string', 'length' => 14],
            [['loopback'], 'string', 'max' => 50],
            [['loopback'], 'ip'],
            ['mac_address', 'match', 'pattern' => '/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})|([0-9a-fA-F]{4}\\.[0-9a-fA-F]{4}\\.[0-9a-fA-F]{4})$/'],

            // Unique Validation
            ['sapid', 'unique'],
            ['hostname', 'unique'],
            ['loopback', 'unique'],
            ['mac_address', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sapid' => 'Sapid',
            'hostname' => 'Hostname',
            'loopback' => 'Loopback',
            'mac_address' => 'Mac Address',
            'created_date' => 'Created Date',
        ];
    }
}
