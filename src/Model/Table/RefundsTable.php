<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Refunds Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \App\Model\Entity\Refund newEmptyEntity()
 * @method \App\Model\Entity\Refund newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Refund> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Refund get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Refund findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Refund patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Refund> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Refund|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Refund saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Refund>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Refund>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Refund>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Refund> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Refund>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Refund>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Refund>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Refund> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RefundsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('refunds');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
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
            ->integer('order_id')
            ->notEmptyString('order_id');

        $validator
            ->scalar('refund_request')
            ->allowEmptyString('refund_request');

        $validator
            ->scalar('refund_response')
            ->allowEmptyString('refund_response');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['order_id'], 'Orders'), ['errorField' => 'order_id']);

        return $rules;
    }
}
