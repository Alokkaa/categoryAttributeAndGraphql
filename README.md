# categoryAttributeAndGraphql

This Query Retrieve Attribute :

{
  get_custom_attribute(category_attribute_code: category_mobile_image){
    id
    attribute_code
    title
  }  
}



This Query To get Attribute Value : 

{
  get_attribute_value(
    category_id: 9285
    category_attribute_code: "category_mobile_image"
  ){
    attribute_value
  }  
}
