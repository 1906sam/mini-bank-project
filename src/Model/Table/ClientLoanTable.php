<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientLoan Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClientDetails
 * @property \Cake\ORM\Association\HasMany $ClientLoanPayments
 *
 * @method \App\Model\Entity\ClientLoan get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientLoan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientLoan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientLoan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoan findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientLoanTable extends Table
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

        $this->table('client_loan');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ClientDetails', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ClientLoanPayments', [
            'foreignKey' => 'client_loan_id'
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
            ->integer('rate_of_interest')
            ->requirePresence('rate_of_interest', 'create')
            ->notEmpty('rate_of_interest');

        $validator
            ->integer('loan_amount')
            ->requirePresence('loan_amount', 'create')
            ->notEmpty('loan_amount');

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
