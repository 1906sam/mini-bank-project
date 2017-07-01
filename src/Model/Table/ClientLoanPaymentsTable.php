<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientLoanPayments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClientLoan
 *
 * @method \App\Model\Entity\ClientLoanPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientLoanPayment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientLoanPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoanPayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientLoanPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoanPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientLoanPayment findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientLoanPaymentsTable extends Table
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

        $this->table('client_loan_payments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ClientLoan', [
            'foreignKey' => 'client_loan_id',
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
            ->integer('interest_received')
            ->requirePresence('interest_received', 'create')
            ->notEmpty('interest_received');

        $validator
            ->integer('installment_received')
            ->requirePresence('installment_received', 'create')
            ->allowEmpty('installment_received');

        $validator
            ->integer('final_loan_amount')
            ->requirePresence('final_loan_amount', 'create')
            ->notEmpty('final_loan_amount');

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
        $rules->add($rules->existsIn(['client_loan_id'], 'ClientLoan'));

        return $rules;
    }
}
