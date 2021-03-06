<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientFd Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClientDetails
 *
 * @method \App\Model\Entity\ClientFd get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientFd newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientFd[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientFd|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientFd patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientFd[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientFd findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientFdTable extends Table
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

        $this->table('client_fd');
        $this->displayField('id');
        $this->primaryKey('id');

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
            ->integer('fd_amount')
            ->requirePresence('fd_amount', 'create')
            ->notEmpty('fd_amount');

        $validator
            ->integer('time_duration')
            ->requirePresence('time_duration', 'create')
            ->notEmpty('time_duration');

        $validator
            ->numeric('rate_of_interest')
            ->requirePresence('rate_of_interest', 'create')
            ->notEmpty('rate_of_interest');

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
