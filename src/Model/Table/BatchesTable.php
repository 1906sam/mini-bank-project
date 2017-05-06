<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Batches Model
 *
 * @property \Cake\ORM\Association\HasMany $BatchUser
 *
 * @method \App\Model\Entity\Batch get($primaryKey, $options = [])
 * @method \App\Model\Entity\Batch newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Batch[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Batch|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Batch patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Batch[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Batch findOrCreate($search, callable $callback = null, $options = [])
 */
class BatchesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('batches');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('BatchUser', [
            'foreignKey' => 'batch_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('batch_name', 'create')
            ->notEmpty('batch_name');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->dateTime('created_date')
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');

        $validator
            ->dateTime('modified_date')
            ->allowEmpty('modified_date');

        return $validator;
    }
}
