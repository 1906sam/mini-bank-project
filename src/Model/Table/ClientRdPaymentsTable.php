<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientRdPayments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClientRd
 *
 * @method \App\Model\Entity\ClientRdPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientRdPayment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientRdPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientRdPayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientRdPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientRdPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientRdPayment findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientRdPaymentsTable extends Table
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

        $this->table('client_rd_payments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ClientRd', [
            'foreignKey' => 'client_rd_id',
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
            ->integer('installment_received')
            ->requirePresence('installment_received', 'create')
            ->notEmpty('installment_received');

        $validator
            ->integer('final_rd_amount');
            //->requirePresence('final_rd_amount', 'create')
            //->notEmpty('final_rd_amount');

        $validator
            ->integer('penalty')
            ->requirePresence('penalty', 'create')
            ->notEmpty('penalty');

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
        $rules->add($rules->existsIn(['client_rd_id'], 'ClientRd'));

        return $rules;
    }
}
