function validateName(input) {
    const value = input.value.trim();
    const valid = value.length > 0 && value.length <= 20;
    input.classList.toggle('invalid', !valid);
    input.classList.toggle('valid', valid);
    document.getElementById('name-error').textContent = valid ? '' : '入力は必須です。';
    return valid;
  }

  function validateAddress(input) {
    const value = input.value.trim();
    const valid = value.length > 0;
    input.classList.toggle('invalid', !valid);
    input.classList.toggle('valid', valid);
    document.getElementById('address-error').textContent = valid ? '' : '入力は必須です。';
    return valid;
  }

  // 送信前にバリデーションを行い、確認メッセージを表示
  function submitForm() {
    const nameValid = validateName(document.getElementById('name'));
    const addressValid = validateAddress(document.getElementById('address'));
    if (nameValid && addressValid) {
        // 商品の数量をhiddenフィールドに設定
        document.getElementById('item1-quantity-hidden').value = document.getElementById('item1-quantity').value;
        document.getElementById('item2-quantity-hidden').value = document.getElementById('item2-quantity').value;
        document.getElementById('item3-quantity-hidden').value = document.getElementById('item3-quantity').value;
        return confirm("本当に送信しますか？");
    } else {
        return false;
    }
  }

  document.getElementById('name').addEventListener('input', function() {
    validateName(this);
  });

  document.getElementById('address').addEventListener('input', function() {
    validateAddress(this);
  });

  // blurイベントでバリデーションを実行
  document.getElementById('name').addEventListener('blur', function() {
    validateName(this);
  });

  document.getElementById('address').addEventListener('blur', function() {
    validateAddress(this);
  });

  // 住所自動入力後のバリデーション
  function afterZip2addr() {
    validateAddress(document.getElementById('address'));
  }

  document.addEventListener('DOMContentLoaded', function() {
    // input type="number" に負の値を入れられないようにする
    var numberInputs = document.querySelectorAll('input[type=number]');
    numberInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (parseInt(this.value) < 0) {
                this.value = '';
            }
        });
    });
});