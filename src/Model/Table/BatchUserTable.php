<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BatchUser Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Batches
 * @property \Cake\ORM\Association\BelongsTo $ClientDetails
 *
 * @method \App\Model\Entity\BatchUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\BatchUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BatchUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BatchUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BatchUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BatchUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BatchUser findOrCreate($search, callable $callback = null, $options = [])
 */
class BatchUserTable extends Table
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

        $this->table('batch_user');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Batches', [
            'foreignKey' => 'batch_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ClientDetails', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
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
            ->dateTime('created_date')
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');

        $validator
            ->dateTime('modified_date')
            ->allowEmpty('modified_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['batch_id'], 'Batches'));
        $rules->add($rules->existsIn(['client_id'], 'ClientDetails'));

        return $rules;
    }
}
