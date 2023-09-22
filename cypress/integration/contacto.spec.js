/// <reference types="cypress" />

describe("Prueba el formulario de contacto", () => {
  it("Prueba la pagina de contacto y el envio de emails", () => {
    cy.visit("/contacto");

    cy.get('[data-cy="heading-contacto"]').should("exist");
    cy.get('[data-cy="heading-contacto"]')
      .invoke("text")
      .should("equal", "Contacto");
    cy.get('[data-cy="heading-contacto"]')
      .invoke("text")
      .should("not.equal", "Contactanos");

    cy.get('[data-cy="formulario-heading"]').should("exist");
    cy.get('[data-cy="formulario-heading"]')
      .invoke("text")
      .should("equal", "Llene el Formulario de Contacto");
    cy.get('[data-cy="formulario-heading"]')
      .invoke("text")
      .should("not.equal", "Llene el Formulario para contactar");

    cy.get('[data-cy="formulario-contacto"]').should("exist");
  });

  it("Llena los campos del formulario", () => {
    cy.get('[data-cy="input-nombre"]').type("Samuel");
    cy.get('[data-cy="input-mensaje"]').type("Deseo comprar una casa");
    cy.get('[data-cy="input-opciones"]').select("Compro");
    cy.get('[data-cy="input-precio"]').type("500000000");
    cy.get('[data-cy="forma-contacto"]').eq("1").check();

    cy.wait(1000);

    cy.get('[data-cy="forma-contacto"]').eq("0").check();
    cy.get('[data-cy="input-telefono"]').type("3142261859");
    cy.get('[data-cy="input-fecha"]').type("2021-07-07");
    cy.get('[data-cy="input-time"]').type("16:30");

    cy.get('[data-cy="formulario-contacto"]').submit();

    cy.get('[data-cy="alerta-envio-formulario"]').should("exist");
    cy.get('[data-cy="alerta-envio-formulario"]')
      .invoke("text")
      .should("equal", "Mensaje enviado correctamente");
    cy.get('[data-cy="alerta-envio-formulario"]')
      .should("have.class", "alerta")
      .and("have.class", "exito")
      .and("not.have.class", "error");
  });
});
