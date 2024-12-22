<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderItems Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\BelongsTo $Orders
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\OrderItem newEmptyEntity()
 * @method \App\Model\Entity\OrderItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\OrderItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\OrderItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\OrderItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\OrderItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\OrderItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\OrderItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderItemsTable extends Table
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

        $this->setTable('order_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->integer('product_id')
            ->notEmptyString('product_id');

        $validator
            ->integer('quantity')
            ->notEmptyString('quantity');

        $validator
            ->integer('refunded_quantity')
            ->notEmptyString('refunded_quantity');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->decimal('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmptyString('subtotal');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }
}
