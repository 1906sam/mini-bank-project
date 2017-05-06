<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientRd Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClientDetails
 * @property \Cake\ORM\Association\HasMany $ClientRdPayments
 *
 * @method \App\Model\Entity\ClientRd get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientRd newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientRd[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientRd|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientRd patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientRd[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientRd findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientRdTable extends Table
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

        $this->table('client_rd');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ClientDetails', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ClientRdPayments', [
            'foreignKey' => 'client_rd_id'
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
            ->integer('rd_amount')
            ->requirePresence('rd_amount', 'create')
            ->notEmpty('rd_amount');

        $validator
            ->integer('rate_of_interest')
            ->requirePresence('rate_of_interest', 'create')
            ->notEmpty('rate_of_interest');

        $validator
            ->integer('time_duration')
            ->requirePresence('time_duration', 'create')
            ->notEmpty('time_duration');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['client_id'], 'ClientDetails'));

        return $rules;
    }
}
