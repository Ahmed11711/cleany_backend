export const fields = [
  { key: "title", label: "Title", required: 1, placeholder: "Enter Title", type: "text", isString: false },
  { key: "description", label: "Description", required: 1, placeholder: "Enter Description", type: "textarea", isString: false },
  { key: "is_active", label: "Is Active", required: 1, placeholder: "Enter Is Active", type: "boolean", isString: false },
  { key: "image_path", label: "Image Path", required: 1, placeholder: "Enter Image Path", type: "image", isString: true },
  { key: "company_id", label: "Company Id", required: 1, placeholder: "Enter Company Id", type: "number", isString: false },
  { key: "category_id", label: "Category Id", required: 1, placeholder: "Enter Category Id", type: "number", isString: false }
];