<?php
namespace Alokka\AddAttribute\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Catalog\Model\CategoryRepository;

class FetchAttributeValueGraphql implements ResolverInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * RetrieveAttributeGraphql constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|\Magento\Framework\GraphQl\Query\Resolver\Value|mixed
     * @throws GraphQlInputException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {

        if (!isset($args['category_attribute_code']) || empty($args['category_attribute_code']) || !isset($args['category_id']) || empty($args['category_id']))
        {
            throw new GraphQlInputException(__('Invalid parameter list.'));
        }

        $categoryAttributeCode = $args['category_attribute_code'];
        $categoryId = $args['category_id'];

        $category = $this->categoryRepository->get($categoryId);

        return [
            'attribute_value' => $category->getData($categoryAttributeCode)
        ];
    }


}
