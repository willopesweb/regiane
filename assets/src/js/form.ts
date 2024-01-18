import { createNotification } from "./notification";

const forms = document.querySelectorAll(".js-form");

if (forms) {
  forms.forEach((form) => {
    form.addEventListener("submit", handleSubmit);
  });
}
async function handleSubmit(e: Event) {
  e.preventDefault();

  const formData = new FormData(e.target as HTMLFormElement);
  const formDataObject: Record<string, string> = {};

  formData.forEach((value, key) => {
    formDataObject[key] = value as string;
  });

  formDataObject.subject = `${formDataObject.name} enviou uma mensagem pelo site!`;
  formDataObject.emailBody = `<b>Nome: </b>${formDataObject.name}<br><b>Email: </b>${formDataObject.email}<br><b>Mensagem: </b>${formDataObject.message}<br>`;

  console.log(formDataObject);

  try {
    const result = await sendEmail(formDataObject);

    if (result.success) {
      createNotification("E-mail enviado com sucesso", "success");
    } else {
      createNotification(`Erro ao enviar e-mail: ${result.error}`, "error");
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    createNotification("Erro ao enviar e-mail", "error");
  }
}

async function sendEmail(
  formData: Record<string, string>
): Promise<{ success: boolean; error?: string }> {
  try {
    const response = await fetch(`${window.location.origin}/wp-send-mail.php`, {
      method: "POST",
      body: JSON.stringify(formData),
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (response.ok) {
      return { success: true };
    } else {
      const errorResponse = await response.json();
      return {
        success: false,
        error: errorResponse.message || "Erro desconhecido",
      };
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    return { success: false, error: "Erro desconhecido" };
  }
}
