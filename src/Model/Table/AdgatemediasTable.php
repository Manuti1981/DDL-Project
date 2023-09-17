<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Adgatemedias Model
 *
 * @method \App\Model\Entity\Adgatemedia newEmptyEntity()
 * @method \App\Model\Entity\Adgatemedia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Adgatemedia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Adgatemedia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Adgatemedia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Adgatemedia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Adgatemedia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Adgatemedia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adgatemedia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Adgatemedia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Adgatemedia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Adgatemedia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Adgatemedia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdgatemediasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('adgatemedias');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->allowEmptyString('name');

        $validator
            ->scalar('requirements')
            ->allowEmptyString('requirements');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->decimal('epc')
            ->notEmptyString('epc');

        $validator
            ->scalar('click_url')
            ->allowEmptyString('click_url');

        return $validator;
    }
}
