<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientDetails Model
 *
 * @method \App\Model\Entity\ClientDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientDetailsTable extends Table
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

        $this->table('client_details');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('client_name', 'create')
            ->notEmpty('client_name');

        $validator
            ->integer('mobile')
            ->requirePresence('mobile', 'create')
            ->notEmpty('mobile');

        $validator
            ->requirePresence('introducer_person', 'create')
            ->notEmpty('introducer_person');

        $validator
            ->allowEmpty('client_photo');

        $validator
            ->requirePresence('client_sign_photo', 'create')
            ->notEmpty('client_sign_photo');

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
}
