<?php
namespace Alokka\AddAttribute\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Catalog\Api\Data\CategoryAttributeInterface;
use Magento\Catalog\Api\CategoryAttributeRepositoryInterface;
use Psr\Log\LoggerInterface;

class AddAttributeGraphql implements ResolverInterface
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var CategoryAttributeRepositoryInterface
     */
    private $categoryAttributeInfo;

    public function __construct(
        CategoryAttributeRepositoryInterface $categoryAttributeInfo,
        LoggerInterface $logger
    ) {
        $this->categoryAttributeInfo = $categoryAttributeInfo;
        $this->logger = $logger;
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

        if (!isset($args['category_attribute_code']) || empty($args['category_attribute_code']))
        {
            throw new GraphQlInputException(__('Invalid parameter list.'));
        }

        $categoryAttributeCode = $args['category_attribute_code'];

        $categoryAttribute = $this->categoryAttributeInfo->get($categoryAttributeCode);

        return [
            'id' => $categoryAttribute->getId(),
            'attribute_code' => $categoryAttribute->getAttributeCode(),
            'title' => $categoryAttribute->getTitle()
        ];
    }


}
