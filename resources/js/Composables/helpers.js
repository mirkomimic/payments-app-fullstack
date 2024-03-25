function toggleBasedOnTheme(theme, ifLight, ifDark) {
  return theme.global.name.value == 'light' ? ifLight : ifDark
}

function toggleTheme (theme) {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}

const formatInputPrice = (input) => {
  let num;

  num = parseInt(input.replace(/[^\d,-]/g, '').replace(',', '.'));

  num = num.toFixed(2);

  num = (new Intl.NumberFormat('de-DE',
    {
      style: 'decimal',
      minimumFractionDigits: 2
    }).format(parseInt(input.replace(/[^\d,-]/g, '').replace(',', '.'))));

  return num;
}

const formatPrice = (price) => {
  return price.toLocaleString("de-DE", { maximumFractionDigits: 2, minimumFractionDigits: 2 })
}

const removeDotsAndCommas = (value) => {
  return value.replace(/[^\d,-]/g, '').replace(',', '.')
}

const getPriceByProdId = (prices, product_id) => {
  return prices.data.filter((price) => price.product == product_id)
}

const getDefaultPriceByProd = (prices, product) => {
  return prices.data.filter((price) => price.id == product.default_price)
}

const isDefaultPrice = (price, product) => {
  return price.id == product.default_price ? true : false
}

const findDefaultPriceByProd = (prices, product) => {
  return prices.data.find(price => price.id == product.default_price)
}

const rules = {
  required: value => {
    if (value) return true

    return 'The field is required.'
  },
  price: value => {
    const regex = /^-?\d{1,3}(?:\.\d{3})*(?:,\d{2})?$/;

    return regex.test(value) || 'Invalid format.'
  },
  fileCount: value => {
    if (!value || value.length <= 8) {
      return true;
    }
    return 'You can only upload a maximum of 8 files';
  }
}

export {toggleBasedOnTheme, toggleTheme, rules, formatInputPrice, formatPrice,  removeDotsAndCommas, getPriceByProdId, getDefaultPriceByProd, isDefaultPrice, findDefaultPriceByProd}
